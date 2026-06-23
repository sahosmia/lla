<?php

namespace App\Livewire\Pages\Student;

use App\Models\User;
use App\Services\BookingService;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class RescheduleSession extends Component
{
    protected $bookingService;
    public $booking;

    public function boot()
    {
        $this->bookingService = new BookingService(Auth::user());
    }

    public function mount($id)
    {
        $this->booking = $this->bookingService->getBookingDetail($id);
        if (empty($this->booking) || ( !empty($this->booking) && $this->booking->status != 'rescheduled')) {
            return $this->redirect(route('student.bookings'), navigate: true);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.student.reschedule-session');
    }

    #[On('refund-session')]
    public function refundSession()
    {
        try{
            DB::beginTransaction();
            $this->booking = $this->bookingService->getBookingDetail($this->booking?->id);
            $this->bookingService->updateBooking($this->booking, [ 'status'=> 'refunded' ]);
            $this->bookingService->addBookingLog($this->booking, [
                'activityable_id'   => Auth::user()->id,
                'activityable_type' => User::class,
                'type'              => 'refunded'
            ]);

            $orderItem = $this->booking->orderItem;
            if (!empty($orderItem)) {
                $platformFee = $orderItem?->platform_fee;
                (new WalletService())->addFunds(Auth::user()->id, $this->booking->session_fee);
                (new WalletService())->refundFromPendingFunds($this->booking->tutor_id, ($this->booking->session_fee - $platformFee), $orderItem?->order_id);
                Session::flash('rescheduled_msg', __('calendar.refunded_successfully'));
            } else {
                Session::flash('rescheduled_msg', __('calendar.refunded_error'));
            }
            DB::commit();
        }catch(\Exception $ex){
            Log::info($ex);
            DB::rollBack();
            Session::flash('rescheduled_msg', __('calendar.refunded_error'));
        }
        return $this->redirect(route('student.bookings'));
    }

    public function confirmReschedule()
    {
        Session::flash('rescheduled_msg', __('calendar.rescheduled_successfully'));
        $this->bookingService->confirmRescheduledBooking($this->booking);
        return $this->redirect(route('student.bookings'));
    }
}
