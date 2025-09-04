<?php

namespace App\Livewire\Pages\Tutor\ManageSessions;

use App\Livewire\Forms\Tutor\ManageSessions\SessionBookingForm;
use App\Models\Day;
use App\Services\BookingService;
use App\Services\SubjectService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nwidart\Modules\Facades\Module;

class MyCalendar extends Component
{
    public $availableSlots, $subjectGroups, $days;
    public $currentDate, $currentMonth, $currentYear, $startOfCalendar, $endOfCalendar, $startOfWeek;

    public $subjectGroupIds = null;
    protected $bookingService, $subjectService;

    public SessionBookingForm $form;
    public $MAX_SESSION_CHAR = 500;
    public $isLoading = true;
    public $activeRoute;
    public $templates = [];
    public $template_id = '';
    public $assign_quiz_certificate = 'any';
    public $allowed_for_subscriptions = 0;
    public function boot() {
        $this->bookingService = new BookingService(Auth::user());
        $this->subjectService  = new SubjectService(Auth::user());
    }

    public function mount() {
        $this->activeRoute = Route::currentRouteName();
        $this->subjectGroups = $this->subjectService->getUserSubjectGroups(['subjects:id,name','group:id,name']);
        $this->startOfWeek = (int) (setting('_lernen.start_of_week') ?? Carbon::SUNDAY); 
        $this->days = Day::get();
        if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify')){
            $this->templates = get_templates();
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        if ($this->getErrorBag()->any()) {
            $this->dispatch('loadPageJs');
        }
        $this->makeCalendar($this->currentDate);
        $this->availableSlots = $this->bookingService->getAvailableSlots($this->subjectGroupIds, $this->currentDate);
        $this->dispatch('initCalendarJs', currentDate: parseToUserTz($this->currentDate->copy())->format('F, Y'));
        return view('livewire.pages.tutor.manage-sessions.my-calendar');
    }

    public function loadData() {
        $this->isLoading = true;
        $this->isLoading = false;
    }

    public function addSessionForm(){
        $this->form->reset();
        $this->form->resetErrorBag();
        $this->dispatch('toggleModel', id:'booking-modal', action:'show');
    }

    public function addSession(){
        $validatedData = $this->form->validateData();
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('toggleModel', id: 'booking-modal', action: 'hide');
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        if (!empty($this->template_id)) {
            $validatedData['template_id'] = $this->template_id;
        }

        if(isActiveModule('upcertify') && isActiveModule('quiz')){
            $validatedData['assign_quiz_certificate'] =  $this->assign_quiz_certificate;
        }

        if(Module::has('subscriptions') && Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor'){
            $validatedData['allowed_for_subscriptions'] = $this->allowed_for_subscriptions ?? 0;
        }
        $sessionsAdded = $this->bookingService->addUserSubjectGroupSessions($validatedData);
        if($sessionsAdded)
        $this->form->reset();
        $this->dispatch('toggleModel', id: 'booking-modal', action: 'hide');
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.success_message'));
    }

    public function updatedForm($value, $key){
        if($key == 'subject_group_id' && !empty($value)) {
            $subjectGroup = $this->subjectService->getUserGroupSubject($value);
            if (isPaidSystem()) {
                $this->form->setFee($subjectGroup->hour_rate);
            }
        }
    }

    public function updatedCurrentMonth($month) {
        $date = "$month/01/$this->currentYear";
        $this->makeCalendar($date);
    }

    public function jumpToDate($date=null) {
        if (!empty($date)) {
            $date = Carbon::createFromFormat('d F, Y', "01 $date");
        }
        $this->makeCalendar($date);
    }

    public function updatedCurrentYear($year) {
        $date = "$this->currentMonth/01/$year";
        $this->makeCalendar($date);
    }

    public function previousMonthCalendar($dateString) {
        $date = Carbon::createFromDate($dateString);
        $date->subMonth();
        $this->makeCalendar($date);
    }

    public function nextMonthCalendar($dateString) {
        $date = Carbon::createFromDate($dateString);
        $date->addMonth();
        $this->makeCalendar($date);
    }

    private function makeCalendar($date = null) {
        $date = empty($date) ? Carbon::now(getUserTimezone()) : Carbon::createFromDate($date)->setTimezone(getUserTimezone());
        $this->currentDate = $date;
        $this->currentMonth = $date->format('m');
        $this->currentYear = $date->format('Y');
        $this->startOfCalendar = $date->copy()->firstOfMonth()->startOfWeek($this->startOfWeek);
        $this->endOfCalendar = $date->copy()->lastOfMonth()->endOfWeek(getEndOfWeek($this->startOfWeek));
    }
}
