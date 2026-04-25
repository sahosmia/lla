<?php

namespace App\Livewire\Pages\Admin\Dispute;

use App\Jobs\CompleteBookingJob;
use App\Jobs\SendDbNotificationJob;
use App\Jobs\SendNotificationJob;
use App\Models\User;
use App\Services\BookingService;
use App\Services\DisputeService;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;


class ManageDispute extends Component
{
    public $disputeId;
    public $user;
    public $userDispute;
    public $winningParty    = '';
    public $withChat        = 'student';
    public $comment         = '';
    public $message         = '';
    public $winnerMessage;
    public $closeDisputeMessage;
    public $loserMessage;
    protected $disputeService;
    protected $bookingService;

    public function boot()
    {
        $this->disputeService = new DisputeService(Auth::user());
        $this->bookingService = new BookingService(Auth::user());
        $this->user           = Auth::user();
    }

    public function mount($id)
    {
        $this->disputeId      = $this->disputeService->getDisputeId($id);
        $this->winnerMessage  = setting('_dispute_setting.dispute_winner_message') ?? '';
        $this->loserMessage   = setting('_dispute_setting.dispute_loser_message') ?? '';
        $this->closeDisputeMessage = setting('_dispute_setting.close_dispute_tooltip_message') ?? '';
    }
    

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $dispute             = $this->disputeService->getDisputeById($this->disputeId);
        $this->userDispute   = $dispute;
        $userChat            = $this->disputeService->getUserChat($this->disputeId,$this->withChat);
        return view('livewire.pages.admin.dispute.manage-dispute', compact('dispute', 'userChat'));
    }

    public function changeChat($user)
    {
        $this->withChat   = $user;
        $this->message    = '';
    }

    public function setWinningParty($party)
    {
        $this->winningParty = $party;
        $this->resetErrorBag();
    }   

    public function resolveDispute($bookingId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $this->validate([
            'comment' => 'required|string|max:255'
        ]);
        
        $booking = $this->bookingService->getBookingById($bookingId);

        $emailData = [
            'studentName'       => User::find($booking->student_id)->profile->first_name . ' ' . User::find($booking->student_id)->profile->last_name,
            'tutorName'         => User::find($booking->tutor_id)->profile->first_name . ' ' . User::find($booking->tutor_id)->profile->last_name,
            'paymentAmount'     => $booking->session_fee,
            'sessionDateTime'   => $booking->start_time,
            'disputeReason'     => $this->comment,
        ];
        
        if($this->winningParty == 'student') {

            $this->refundSession($bookingId,$booking->student_id);
            dispatch(new SendNotificationJob('disputeResolution',User::find($booking->student_id), $emailData));
            dispatch(new SendDbNotificationJob('disputeResolution',User::find($booking->student_id), $emailData));
            $this->disputeService->sendMessage($this->disputeId, $this->winnerMessage, "student");
            $this->disputeService->sendMessage($this->disputeId, $this->loserMessage, "tutor");
            $this->disputeService->changeStatus($this->disputeId, 'closed');
            $this->disputeService->addWinnerId($this->disputeId, $booking->student_id);

        } else {

            $this->bookingService->updateBooking($booking, ['status' => 'completed']);
            (new WalletService())->makePendingFundsAvailable($booking->tutor_id, ($booking->session_fee - $booking?->orderItem?->platform_fee), $booking?->orderItem?->order_id);
            dispatch(new CompleteBookingJob($booking));
            dispatch(new SendNotificationJob('disputeResolution',User::find($booking->tutor_id), $emailData));
            dispatch(new SendDbNotificationJob('disputeResolution',User::find($booking->tutor_id), $emailData));
            $this->disputeService->sendMessage($this->disputeId, $this->winnerMessage, "tutor");
            $this->disputeService->sendMessage($this->disputeId, $this->loserMessage, "student");
            $this->disputeService->changeStatus($this->disputeId, 'closed');
            $this->disputeService->addWinnerId($this->disputeId, $booking->tutor_id);
        }

        $this->dispatch('showAlertMessage', type: 'success',  message: __('dispute.dispute_resolved'));
        $this->comment      = '';
        $this->winningParty = '';
    }

    public function sendMessage()
    {

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        
        if($this->userDispute?->status == 'closed' || trim($this->message) == '') {
            return;
        }
        $this->disputeService->sendMessage($this->disputeId, $this->message, $this->withChat);
        if($this->withChat == 'student') {    
            $this->disputeService->changeStatus($this->disputeId, 'under_review');
        } else {
            $this->disputeService->changeStatus($this->disputeId, 'in_discussion');
        }
        $this->message = '';
        $this->dispatch('messageSent');
    }


    public function refundSession($bookingId,$studentId)
    {
        try{
            DB::beginTransaction();
            $booking = $this->bookingService->getBookingDetail($bookingId);
            $this->bookingService->updateBooking($booking, [ 'status'=> 'refunded' ]);
            $this->bookingService->addBookingLog($booking, [
                'activityable_id'   => Auth::user()->id,
                'activityable_type' => User::class,
                'type'              => 'refunded'
            ]);

            $orderItem = $booking->orderItem;
            if (!empty($orderItem)) {
                $platformFee = $orderItem?->platform_fee;
                (new WalletService())->addFunds($studentId, $booking?->session_fee);
                (new WalletService())->refundFromPendingFunds($booking?->tutor_id, ($booking?->session_fee - $platformFee), $orderItem?->order_id);
                Session::flash('rescheduled_msg', __('calendar.refunded_successfully'));
            } else {
                Session::flash('rescheduled_msg', __('calendar.refunded_error'));
            }
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            Log::info($ex);
            Session::flash('rescheduled_msg', __('calendar.refunded_error'));
        }
    }
}
    