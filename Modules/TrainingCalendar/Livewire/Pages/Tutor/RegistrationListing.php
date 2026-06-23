<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Tutor;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class RegistrationListing extends Component
{
    use WithPagination;

    public int $trainingId;

    protected TrainingCalendarService $service;

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    public function mount(int $trainingId): void
    {
        $training = $this->service->getTraining($trainingId);

        if (empty($training) || $training->tutor_id !== Auth::id()) {
            abort(404);
        }

        $this->trainingId = $trainingId;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $training = $this->service->getTraining($this->trainingId);
        $registrations = $this->service->getTrainingRegistrations($this->trainingId);

        return view('trainingcalendar::livewire.tutor.registration-listing', compact('training', 'registrations'));
    }
}
