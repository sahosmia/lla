<?php

namespace App\Livewire\Components;

use App\Facades\Cart;
use App\Jobs\SendDbNotificationJob;
use App\Jobs\SendNotificationJob;
use App\Livewire\Forms\Frontend\RequestSessionForm;
use App\Models\SlotBooking;
use App\Models\User;
use App\Models\UserSubjectGroupSubject;
use App\Services\BookingService;
use App\Services\SubjectService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Nwidart\Modules\Facades\Module;

class TutorSessions extends Component
{
    public $currentDate, $startOfWeek, $timezone;
    public $activeId;
    public $disablePrevious, $showCurrent = false, $isCurrent = false;
    public $dateRange = [];
    public $availableSlots = [];
    public $filter = [];
    public $subjectGroups;
    public $userId;
    public $currency_symbol;
    public $pageLoaded = false;
    public $user;
    public $currentSlot = null;
    public $cartItems = [];
    public $selectedDate = null;
    private $bookingService, $subjectService;

    public RequestSessionForm $requestSessionForm;

    public function render()
    {
        if(!empty($this->timezone) && !empty($this->pageLoaded)){
            $this->availableSlots = $this->bookingService->getTutorAvailableSlots($this->userId, $this->timezone, $this->dateRange, $this->filter);
        }
        $this->cartItems = Cart::content();
        $this->dispatch('initCalendarJs', currentDate: $this->getDateFormat());
        return view('livewire.components.tutor-sessions');
    }

    public function loadPage() {
        $this->currentDate = Carbon::now($this->timezone);
        $this->getRange();
        $this->pageLoaded = true;
    }

    public function boot()
    {
        $this->bookingService = new BookingService($this->user);

    }

    public function mount($user)
    {
        $this->user = $user;
        $this->userId = $user->id;
        $this->selectedDate = now($this->timezone)->toDateString();
        $this->currentDate = parseToUserTz(Carbon::now());
        $this->startOfWeek = (int) (setting('_lernen.start_of_week') ?? Carbon::SUNDAY);
        $this->subjectService = new SubjectService($user);
        $this->subjectGroups = $this->subjectService->getSubjectsByUserRole();
        if(Auth::check()){
            $this->timezone = getUserTimezone();
        }
        $currency               = setting('_general.currency');
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();


        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol'];
        }
    }

    public function showSlotDetail($id) {
        $this->currentSlot =  $this->bookingService->getSlotDetail($id);
        $this->dispatch('toggleModel', id: 'slot-detail', action: 'show');
    }

    public function bookSession($id)
    {
        $slot =  $this->bookingService->getSlotDetail($id);
        if(!empty($slot)){
            if( $slot->total_booked < $slot->spaces) {
                $bookedSlot = $this->bookingService->reservedBookingSlot($slot, $this->user);
                $data = [
                    'id' => $bookedSlot->id,
                    'slot_id' => $slot->id,
                    'tutor_id' => $this->user->id,
                    'tutor_name' => $this->user?->profile?->full_name,
                    'session_time' => parseToUserTz($slot->start_time, $this->timezone)->format('h:i a').' - '.parseToUserTz($slot->end_time, $this->timezone)->format('h:i a'),
                    'subject_group' => $slot->subjectGroupSubjects?->userSubjectGroup?->group?->name,
                    'subject' => $slot->subjectGroupSubjects?->subject?->name,
                    'image' => $slot->subjectGroupSubjects?->image,
                    'currency_symbol' => $this->currency_symbol,
                    'price' => number_format($slot->session_fee, 2),
                ];

                if(Module::has('subscriptions') && Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor'){
                    $data['allowed_for_subscriptions'] = $slot->meta_data['allowed_for_subscriptions'] ?? 0;
                }

                Cart::add(
                    cartableId: $data['id'], 
                    cartableType: SlotBooking::class, 
                    name: $data['subject'], 
                    qty: 1, 
                    price: $slot->session_fee, 
                    options: $data
                );

                if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
                    $response = \Modules\KuponDeal\Facades\KuponDeal::applyCouponIfAvailable($slot->subjectGroupSubjects->id, UserSubjectGroupSubject::class);
                    if($response['status'] == 'success'){
                        $this->dispatch('cart-updated', cart_data: Cart::content(), discount: formatAmount(Cart::discount(), true), total: formatAmount(Cart::total(), true), subTotal: formatAmount(Cart::subtotal(), true), toggle_cart: 'open');
                    }
                } else {
                    $this->dispatch('cart-updated', cart_data: Cart::content(), total: formatAmount(Cart::total(), true), subTotal: formatAmount(Cart::subtotal(), true), toggle_cart: 'open');
                }

                if(!empty($this->currentSlot)){
                    $this->dispatch('toggleModel', id: 'slot-detail', action: 'hide');
                }
            } else {
                $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title') , message: __('tutor.not_available_slot'));
            }

        }
    }

    #[On('remove-cart')]
    public function removeCartItem($params)
    {
        if(!empty($params['cartable_id']) && !empty($params['cartable_type'])){
            $this->bookingService->removeReservedBooking($params['cartable_id']);
            Cart::remove(
                cartableId: $params['cartable_id'], 
                cartableType: $params['cartable_type']
            );
            $this->dispatch('cart-updated', cart_data: Cart::content(), discount: formatAmount(Cart::discount(), true), total: formatAmount(Cart::total(), true), subTotal: formatAmount(Cart::subtotal(), true), toggle_cart: 'open');
        }
    }

    public function jumpToDate($date=null) {
        if (!empty($date)) {
            $format = 'Y-m-d';
            $this->currentDate = Carbon::createFromFormat($format, $date, $this->timezone);
        } else {
            $this->currentDate = Carbon::now($this->timezone);
        }
        $this->getRange();
    }

    public function nextBookings() {
        $this->currentDate->setTimezone($this->timezone);
        $this->currentDate->addWeek();
        $this->selectedDate = $this->currentDate->startOfWeek($this->startOfWeek)->toDateString();
        $this->getRange();
    }

    public function previousBookings() {
        $this->currentDate->setTimezone($this->timezone);
        $this->currentDate->subWeek();
        $this->selectedDate = $this->currentDate->startOfWeek($this->startOfWeek)->toDateString();
        $this->getRange();
    }

    protected function getRange(){
        $start = $end = null;
        $this->disablePrevious = $this->isCurrent = false;
        $now = Carbon::now($this->timezone);
        $start = $this->currentDate->copy()->startOfWeek($this->startOfWeek)->toDateString()." 00:00:00";
        $end = $this->currentDate->copy()->endOfWeek(getEndOfWeek($this->startOfWeek))->toDateString()." 23:59:59";
        if ($now->between($this->currentDate->copy()->startOfWeek($this->startOfWeek), $this->currentDate->copy()->endOfWeek(getEndOfWeek($this->startOfWeek)))) {
            $this->disablePrevious = true;
            $this->isCurrent = true;
        }
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $start, $this->timezone);
        $endDate   = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $end, $this->timezone);
        $this->dateRange['start_date']  = parseToUTC($startDate);
        $this->dateRange['end_date']    = parseToUTC($endDate);
        $this->selectedDate = $this->currentDate->copy()->toDateString();
    }

    protected function getDateFormat() {
        $start = $this->currentDate->copy()->startOfWeek($this->startOfWeek);
        $end = $this->currentDate->copy()->endOfWeek(getEndOfWeek($this->startOfWeek));
        return $start->format('F') . " ". $start->format('d') . " - " . $end->format('F') . " ". $end->format('d') . " " . $end->format('Y');
    }

    public function setDefaultTimezone($timezone)
    {
        if(empty($this->timezone)){
            $this->timezone = $timezone;
        }
    }

    public function updatedTimezone($value)
    {
        Cart::clear();
        $this->dispatch('cart-updated', cart_data: Cart::content(), discount: formatAmount(Cart::discount(), true), total: formatAmount(Cart::total(), true), subTotal: formatAmount(Cart::subtotal(), true), toggle_cart: 'close');
        if(Auth::check()){
            $service = new UserService(Auth::user());
            $service->setAccountSetting('timezone',[$value]);
            Cache::forget('userTimeZone_' . Auth::user()?->id);
        }
        $this->currentDate = Carbon::now($value);
    }

    public function showSlotsForDate($date)
    {
        $this->selectedDate = $date;
    }

    public function openModel(){
        if(Auth::check()){
            if(Auth::user()->role == 'student'){
                $this->requestSessionForm->setUserFormData(Auth::user());
                $this->dispatch('toggleModel', id:'requestsession-popup', action:'show');
            } else {
                $this->dispatch('showAlertMessage', type: 'error', message: __('general.not_allowed'));
            }
        } else {
            $this->dispatch('showAlertMessage', type: 'error',  message: __('general.login_error'));
        }
    }

    public function sendRequestSession(){
        $this->requestSessionForm->validateData();
        $response = isDemoSite();
        if( $response ){
            $this->requestSessionForm->reset();
            $this->dispatch('toggleModel', id:'requestsession-popup', action:'hide');
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $templateData = [
            'userName' => $this->user?->profile?->full_name, 
            'studentName' => $this->requestSessionForm->last_name, 
            'studentEmail' => $this->requestSessionForm->email, 
            'sessionType' => __('tutor.'.$this->requestSessionForm->type.'_session'), 
            'message' => $this->requestSessionForm->message
        ];
        dispatch(new SendNotificationJob('sessionRequest', $this->user, $templateData));
        dispatch(new SendDbNotificationJob('sessionRequest', $this->user, $templateData));
        dispatch(new SendNotificationJob('sessionRequest', User::admin(), $templateData));
        $this->dispatch('toggleModel', id:'requestsession-popup', action:'hide');
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('tutor.request_session_success'));
        $this->requestSessionForm->reset();
    }

    public function getFreeSession($slotId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $slot = $this->bookingService->getSlotDetail($slotId);

        if(empty($slot)) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('tutor.slot_not_available') , message: __('tutor.slot_not_available'));
            return;
        }

        if($slot->total_booked >= $slot->spaces) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('tutor.slot_not_available') , message: __('tutor.slot_not_available'));
            return;
        }
       
        $response = $this->bookingService->createFreeBookingSlot($slot, $this->user);

         $this->dispatch('toggleModel', id:'slot-detail', action:'hide');

        if(!empty($response) && $response['success'] == false) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title') , message: $response['message']);
            return;
        }

       
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('tutor.session_booked'));
            
    }

}
