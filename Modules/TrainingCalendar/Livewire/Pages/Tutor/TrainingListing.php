<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Tutor;

use Illuminate\Support\Facades\Auth;
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

    public function deleteTraining(int $trainingId): void
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $training = $this->service->getTraining($trainingId);

        if (empty($training) || $training->tutor_id !== Auth::id()) {
            return;
        }

        $this->service->deleteTraining($training);
        $this->dispatch('showAlertMessage', type: 'success', message: __('trainingcalendar::trainingcalendar.training_deleted'));
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $trainings = $this->service->getTutorTrainings(Auth::id(), [
            'keyword' => $this->keyword,
            'status' => $this->status,
            'per_page' => 10,
        ]);

        return view('trainingcalendar::livewire.tutor.training-listing', compact('trainings'));
    }
}
