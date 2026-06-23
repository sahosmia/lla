<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Admin;

use Larabuild\Optionbuilder\Facades\Settings;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ModuleSettings extends Component
{
    public string $allow_free_training = 'yes';
    public string $enforce_registration_deadline = 'yes';
    public string $enable_seat_limit = 'yes';
    public int $default_max_seats = 50;
    public string $require_login = 'yes';

    public function mount(): void
    {
        $this->allow_free_training = trainingCalendarSetting('allow_free_training', 'yes');
        $this->enforce_registration_deadline = trainingCalendarSetting('enforce_registration_deadline', 'yes');
        $this->enable_seat_limit = trainingCalendarSetting('enable_seat_limit', 'yes');
        $this->default_max_seats = (int) trainingCalendarSetting('default_max_seats', 50);
        $this->require_login = trainingCalendarSetting('require_login', 'yes');
    }

    public function save(): void
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $this->validate([
            'allow_free_training' => 'required|in:yes,no',
            'enforce_registration_deadline' => 'required|in:yes,no',
            'enable_seat_limit' => 'required|in:yes,no',
            'default_max_seats' => 'required|integer|min:1',
            'require_login' => 'required|in:yes',
        ]);

        Settings::set('_training_calendar', 'allow_free_training', $this->allow_free_training);
        Settings::set('_training_calendar', 'enforce_registration_deadline', $this->enforce_registration_deadline);
        Settings::set('_training_calendar', 'enable_seat_limit', $this->enable_seat_limit);
        Settings::set('_training_calendar', 'default_max_seats', $this->default_max_seats);
        Settings::set('_training_calendar', 'require_login', 'yes');

        $this->dispatch('showAlertMessage', type: 'success', message: __('trainingcalendar::trainingcalendar.settings_saved'));
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('trainingcalendar::livewire.admin.module-settings');
    }
}
