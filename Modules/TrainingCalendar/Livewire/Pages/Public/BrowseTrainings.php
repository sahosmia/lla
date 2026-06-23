<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Public;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class BrowseTrainings extends Component
{
    use WithPagination;

    public string $keyword = '';
    public string $type = '';

    protected TrainingCalendarService $service;

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    public function updatingKeyword(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $trainings = $this->service->getPublishedTrainings([
            'keyword' => $this->keyword,
            'type' => $this->type,
            'per_page' => 12,
        ]);

        return view('trainingcalendar::livewire.public.browse-trainings', compact('trainings'))
            ->extends('layouts.frontend-app', [
                'pageTitle' => __('trainingcalendar::trainingcalendar.browse_trainings'),
            ]);
    }
}
