<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Booking\CreateDisputeRequest;
use App\Http\Requests\Student\Booking\ReviewStoreRequest;
use App\Http\Resources\SlotBookingResource;
use App\Models\User;
use App\Services\BookingService;
use App\Http\Resources\SubjectGroupResource;
use App\Services\SubjectService;
use App\Http\Resources\SubjectResource;
use App\Jobs\CompleteBookingJob;
use App\Jobs\SendNotificationJob;
use App\Models\SlotBooking;
use App\Services\DisputeService;
use App\Services\WalletService;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Disputes\DisputeResource;
use Illuminate\Support\Str;
use App\Http\Resources\Disputes\DisputeCollection;
use App\Http\Resources\Disputes\DisputeDiscussion;
use App\Livewire\Pages\Admin\Bookings\Bookings;

class BookingController extends Controller
{
    use ApiResponser;

    public function getUpComingBooking(Request $request)
    {
        $filter         = $request->filter ?? [];
        $showBy         = $request->show_by;
        $type           = $request->type;

        $user = User::where('id', Auth::user()->id)->first();

        if (!$user) {
            return $this->error(data: null,message: __('api.user_not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if($showBy == 'daily'){
            if (!empty($request->start_date)) {
                $startDate  = Carbon::parse($request->start_date,getUserTimezone())->format('Y-m-d');
                $endDate    = Carbon::parse($request->end_date,getUserTimezone())->format('Y-m-d');
            }
            else {
                $startDate  =   Carbon::now(getUserTimezone())->format('Y-m-d');
                $endDate    =   Carbon::now(getUserTimezone())->format('Y-m-d');

            }

        } else if($showBy == 'weekly'){
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $startDate  = Carbon::parse($request->start_date,getUserTimezone())->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                $endDate    = Carbon::parse($request->start_date,getUserTimezone())->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
            }
            else {
                $startDate  =   Carbon::now(getUserTimezone())->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                $endDate    =   Carbon::now(getUserTimezone())->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
            }
        } else {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $startDate  = Carbon::parse($request->start_date,getUserTimezone())->firstOfMonth()->format('Y-m-d');
                $endDate    = Carbon::parse($request->start_date,getUserTimezone())->lastOfMonth()->format('Y-m-d');
            }
            else {
                $startDate  =   Carbon::now(getUserTimezone())->firstOfMonth()->format('Y-m-d');
                $endDate    =   Carbon::now(getUserTimezone())->lastOfMonth()->format('Y-m-d');
            }
        }

        if ($type == 'prev' && $showBy == 'daily') {
            $startDate  = Carbon::parse($startDate)->subDays()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->subDays()->format('Y-m-d');
        } elseif ($type == 'next' && $showBy == 'daily' ) {
            $startDate  = Carbon::parse($startDate)->addDays()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->addDays()->format('Y-m-d');
        } elseif ($type == 'prev' && $showBy == 'weekly') {
            $startDate  = Carbon::parse($startDate)->subWeek()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->subWeek()->format('Y-m-d');
        } elseif ($type == 'next'  && $showBy == 'weekly') {
            $startDate  = Carbon::parse($startDate)->addWeek()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->addWeek()->format('Y-m-d');
        } elseif ($type == 'prev') {
            $startDate  = Carbon::parse($startDate)->subMonth()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->subMonth()->format('Y-m-d');
        } elseif ($type == 'next') {
            $startDate  = Carbon::parse($startDate)->addMonth()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->addMonth()->format('Y-m-d');
        }

        $dateRange = [
            'start_date'    => $startDate." 00:00:00",
            'end_date'      => $endDate." 23:59:59",
        ];

        $bookingService = new BookingService(Auth::user());
        $upcomingBookings = $bookingService->getUserBookings($dateRange, $showBy, $filter);
        $userSlot = [
            'start_date'    => $startDate." 00:00:00",
            'end_date'      => $endDate." 23:59:59"
        ];
        
        foreach ($upcomingBookings as $date => $slots) {
           $userSlot[$date] = SlotBookingResource::collection($slots);
        }

        return $this->success(data: $userSlot);
    }

    public function getSubjectGroups()
    {
        $subjectGroups = (new subjectService)->getSubjectGroups();
        return $this->success(data: SubjectGroupResource::collection($subjectGroups));
    }

    public function getSubjects()
    {
        $subjects = (new subjectService)->getSubjects();
        return $this->success(data: SubjectResource::collection($subjects));
    }

    public function completeBooking($bookingId)
    {
        $response = isDemoSite();
        if($response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $booking = (new BookingService(Auth::user()))->getBookingById($bookingId);
        if($booking->status != 'active' || Carbon::parse($booking->end_time)->isFuture()) {
           return $this->error(message: __('calendar.unable_to_complete_booking'), code: Response::HTTP_BAD_REQUEST);
        }
        (new BookingService(Auth::user()))->updateBooking($booking, ['status' => 'completed']);
        (new WalletService())->makePendingFundsAvailable($booking->tutor_id, ($booking->session_fee - $booking?->orderItem?->platform_fee), $booking?->orderItem?->order_id);
        dispatch(new CompleteBookingJob($booking));
        return $this->success(message: __('calendar.booking_completed'), code: Response::HTTP_OK);
    }

    public function createDispute(CreateDisputeRequest $request , $bookingId)
    {
        try{
            $response = isDemoSite();
            if($response ){
                return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
            }
            $booking = (new BookingService(Auth::user()))->getBookingById($bookingId);
            if(empty($booking)){
                return $this->error(message: __('general.not_found'), code: Response::HTTP_NOT_FOUND);
            }
            $studentId = $booking->student_id;
            $tutorId   = $booking->tutor_id;
            $responsibleBy  = Auth::id() == $studentId ? $tutorId : $studentId;
            $creatorBy      = Auth::id() == $studentId ? $studentId : $tutorId;

            if (Auth::id() != $studentId) {
                return $this->error(message: __('general.not_allowed'), code: Response::HTTP_UNAUTHORIZED);
            }

            DB::beginTransaction();

            $data = [
                'uuid'              => 'DIS-'. Str::random(6),
                'disputable_id'     => $bookingId,
                'disputable_type'   => SlotBooking::class,
                'responsible_by'    => $responsibleBy,
                'creator_by'        => $creatorBy,
                'dispute_reason'    => $request->reason,
                'dispute_detail'    => $request->description
            ];

            $dispute = (new DisputeService(Auth::user()))->createDispute($data);

            $emailData = [
                'studentName'       => Auth::user()->profile->first_name . ' ' . Auth::user()->profile->last_name,
                'tutorName'         => User::find($tutorId)->profile->first_name . ' ' . User::find($tutorId)->profile->last_name,
                'sessionDateTime'   => $booking->start_time,
                'disputeReason'     => $request->reason,
            ];
            dispatch(new SendNotificationJob('disputeReason',User::admin(), $emailData));
            (new BookingService(Auth::user()))->updateBooking($booking, ['status' => 'disputed']);
            $formattedSessionDateTime = \Carbon\Carbon::parse($emailData['sessionDateTime'])->format('F j, Y, g:i A');
            $disputeMessage = setting('_dispute_setting.dispute_message') ?? '';
            $disputeMessage = str_replace('tutorName:', $emailData['tutorName'], $disputeMessage);
            $disputeMessage = str_replace('formattedSessionDateTime:', $formattedSessionDateTime, $disputeMessage);
            (new DisputeService(Auth::user()))->sendMessage($dispute->id, $disputeMessage, "student");
            DB::commit();
            return $this->success(message: __('calendar.dispute_success_msg'), code: Response::HTTP_OK);
        } catch (Exception $ex) {
            DB::rollBack();
            Log::info($ex);
            return $this->error(message: $ex->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addReview(ReviewStoreRequest $request, $bookingId)
    {
        $response = isDemoSite();
        if($response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $booking = (new BookingService(Auth::user()))->getBookingById($bookingId);
        if(empty($booking)){
            return $this->error(message: __('general.not_found'), code: Response::HTTP_NOT_FOUND);
        }
        if (Auth::id() != $booking->student_id) {
            return $this->error(message: __('general.not_allowed'), code: Response::HTTP_UNAUTHORIZED);
        }
        $reviewAdded = (new BookingService(Auth::user()))->addBookingReview($bookingId, $request->only(['rating', 'comment']));
        if ($reviewAdded) {
            return $this->success(message: __('general.alert_success_msg'), code: Response::HTTP_OK);
        } else {
            return $this->error(message: __('general.error_msg'), code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getDisputes($keyword = '', $perPage = 10, $status = '', $sortBy = '')
    {
        if(Auth::user()->role == 'admin'){
           return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }
        return $this->success(data: new DisputeCollection((new DisputeService(Auth::user()))->getDisputes($keyword, $perPage, $status, $sortBy)), code: Response::HTTP_OK);
    }


    public function getDispute($id)
    {
        if(Auth::user()->role == 'admin'){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }
        $dispute = (new DisputeService(Auth::user()))->getDisputeByID($id);

        if(empty($dispute)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if(auth()->user()->role == 'tutor' && ($dispute?->status == 'pending' || $dispute?->status == 'under_review')){

            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        return $this->success(data: new DisputeResource($dispute), code: Response::HTTP_OK);
    }

    public function getDisputeDiscussion($id)
    {
        if(Auth::user()->role == 'admin'){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $dispute = (new DisputeService(Auth::user()))->getDisputeByID($id);

        if(empty($dispute)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if(auth()->user()->role == 'tutor' && ($dispute?->status == 'pending' || $dispute?->status == 'under_review')){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        $userChat = (new DisputeService(Auth::user()))->getUserChat($dispute->id,auth()->user()->role);
                
        return $this->success(data: DisputeDiscussion::collection($userChat), code: Response::HTTP_OK);
    }

    function addDisputeReply(Request $request, $id)
    {
        $response = isDemoSite();
        if($response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }

        if(Auth::user()->role == 'admin'){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $dispute = (new DisputeService(Auth::user()))->getDisputeByID($id);

        if(empty($dispute)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if(auth()->user()->role == 'tutor' && ($dispute?->status == 'pending' || $dispute?->status == 'under_review')){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if($dispute?->status == 'closed'){
            return $this->error(data: null,message: __('api.dispute_closed'),code: Response::HTTP_FORBIDDEN);
        } 
        
        if($dispute?->status == 'pending'){
            return $this->error(data: null,message: __('api.dispute_pending'),code: Response::HTTP_FORBIDDEN);
        }

        $dispute = (new DisputeService(Auth::user()))->sendMessage($dispute->id, $request->message,auth()->user()->role);

        return $this->success(data: null,message: __('api.reply_added_successfully'), code: Response::HTTP_OK);
    }

    public function bookFreeSlot(Request $request)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(message:  __('general.demosite_res_title'), code: Response::HTTP_FORBIDDEN);
        }

        if (!auth()?->user()?->role == 'student') {
            return $this->error(data: null,message: __('courses::courses.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        if(isPaidSystem()) {
            return $this->error(message:  __('api.slot_booked_paid_error'), code: Response::HTTP_BAD_REQUEST);
        }

        if(empty($request->slot_id)) {
            return $this->error(message:  __('api.slot_not_found'), code: Response::HTTP_BAD_REQUEST);
        }

        $slotId = $request->slot_id;

        $bookingService = new BookingService(Auth::user());

        $slot = $bookingService->getSlotDetail($slotId);

        if(empty($slot)) {
            return $this->error(message:  __('tutor.slot_not_available'), code: Response::HTTP_BAD_REQUEST);

        }

        $tutor = $slot->subjectGroupSubjects?->userSubjectGroup?->tutor;
        if(empty($tutor)) {
            return $this->error(message:  __('tutor.slot_not_available'), code: Response::HTTP_BAD_REQUEST);
        }

        if($slot->bookings()->where('student_id', Auth::user()->id)->exists()) {
            return $this->error(message:  __('api.slot_already_booked'), code: Response::HTTP_BAD_REQUEST);
        }

        if(Carbon::parse($slot->start_time)->isPast()) {
            return $this->error(message:  __('tutor.slot_not_available'), code: Response::HTTP_BAD_REQUEST);
        }

        if($slot->total_booked >= $slot->spaces) {
            return $this->error(message:  __('tutor.slot_not_available'), code: Response::HTTP_BAD_REQUEST);
        }
       
        $response = $bookingService->createFreeBookingSlot($slot, $tutor);

        if(!empty($response) && $response['success'] == false) {
            return $this->error(message: __('genearal.went_wrong'), code: Response::HTTP_BAD_REQUEST);
        }

       
        return $this->success(data: null,message: __('tutor.session_booked'), code: Response::HTTP_OK);
            
    }
}
