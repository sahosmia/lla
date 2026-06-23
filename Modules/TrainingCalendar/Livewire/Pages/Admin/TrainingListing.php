<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class TrainingListing extends Component
{
    use WithPagination;

    public string $keyword = '';
    public string $status = '';

    protected TrainingCalendarService $service;

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $trainings = $this->service->getAdminTrainings([
            'keyword' => $this->keyword,
            'status' => $this->status,
            'per_page' => 10,
        ]);

        return view('trainingcalendar::livewire.admin.training-listing', compact('trainings'));
    }
}
