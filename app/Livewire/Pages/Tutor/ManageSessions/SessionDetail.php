<?php

namespace App\Livewire\Pages\Tutor\ManageSessions;

use App\Livewire\Forms\Tutor\ManageSessions\ResheduleSessionForm;
use App\Livewire\Forms\Tutor\ManageSessions\SubjectSessionStoreForm;
use App\Services\BookingService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Nwidart\Modules\Facades\Module;

class SessionDetail extends Component
{

    public $sessionDetail;
    public $date;
    public $dateRange = [];
    public $editableSlotId, $userSubjectGroupId;
    protected $bookingService;
    public $templates = [];
    public SubjectSessionStoreForm $form;
    public ResheduleSessionForm $rescheduleForm;

    public $MAX_SESSION_CHAR = 500;
    public $isLoading = true;
    public $activeRoute;
    
    public function boot() {
        $this->bookingService = new BookingService(Auth::user());
    }

    public function mount($date){
        if (!$this->isValidDate($date)) {
            return $this->redirect(route('tutor.bookings.manage-sessions'));
        }
        $this->activeRoute = Route::currentRouteName();
        $this->date = parseToUserTz($date);
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date." 00:00:00", getUserTimezone());
        $endDate   = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date." 23:59:59", getUserTimezone());
        $this->dateRange['start_date']  = parseToUTC($startDate);
        $this->dateRange['end_date']    = parseToUTC($endDate);
        if(Module::has('upcertify') && Module::isEnabled('upcertify')){
            $this->templates = get_templates();
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        if ($this->getErrorBag()->any()) {
            $this->dispatch('loadPageJs');
        }
        return view('livewire.pages.tutor.manage-sessions.session-detail');
    }

    public function loadData() {
        $this->isLoading = true;
        $this->sessionDetail = $this->bookingService->getUserSubjectSlots($this->dateRange);
        $this->isLoading = false;
    }

    public function setSession() {
        $this->form->validateData();
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id:'edit-session', action:'hide');
            return;
        }
        $validatedData = $this->form->all();
        $validatedData['subject_group_id'] = $this->userSubjectGroupId;
        if(Module::has('upcertify') && Module::isEnabled('upcertify')){
            $validatedData['meta_data']['template_id'] = $this->form->template_id;
        }

        if(isActiveModule('upcertify') && isActiveModule('quiz')){
            $validatedData['meta_data'] =  array('assign_quiz_certificate' => $this->form->assign_quiz_certificate);
        }

        if(Module::has('subscriptions') && Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor'){
            $validatedData['meta_data']['allowed_for_subscriptions'] = $this->form->allowed_for_subscriptions ? 1 : 0;
        }
        if ($this->form->action == 'edit') {
            $this->bookingService->updateSessionSlotById($this->editableSlotId, $validatedData);
            $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.updated_msg'));
        } else {
            $slotInfo = $this->bookingService->addSessionSlot($this->date, $validatedData);
            if ($slotInfo) {
                $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.success_message'));
            } else {
                $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title') , message: __('calendar.new_session_error'));
            }
        }
        $this->form->reset();
        $this->dispatch('toggleModel', id:'edit-session', action:'hide');
        $this->loadData();
    }

    public function rescheduleSession() {
        $this->rescheduleForm->validateData();
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id:'reschedule-popup', action:'hide');
            return;
        }
        $validatedData = $this->rescheduleForm->all();
        $validatedData['subject_group_id'] = $this->userSubjectGroupId;
        $slotInfo = $this->bookingService->rescheduleSession($this->editableSlotId, $validatedData);
        if ($slotInfo) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('calendar.reschedule_success'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title') , message: __('calendar.reschedule_error'));
        }
        $this->rescheduleForm->reset();
        $this->dispatch('toggleModel', id:'reschedule-popup', action:'hide');
        $this->loadData();
    }

    #[On('delete-slot')]
    public function deleteSlot($params){
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if ($this->bookingService->deleteSlotsMeta($params['id'])) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.delete_record'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title') , message: __('general.error_msg'));
        }
        $this->loadData();
    }

    protected function isValidDate($date){
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
    }
    
}
