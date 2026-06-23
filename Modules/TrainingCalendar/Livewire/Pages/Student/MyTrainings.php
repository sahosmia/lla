<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Student;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class MyTrainings extends Component
{
    use WithPagination;

    protected TrainingCalendarService $service;

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $registrations = $this->service->getStudentRegistrations(Auth::id());

        return view('trainingcalendar::livewire.student.my-trainings', compact('registrations'));
    }
}
