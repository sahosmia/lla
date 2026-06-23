<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Tutor;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\TrainingCalendar\Models\TrainingCalendar;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class CreateTraining extends Component
{
    public ?int $trainingId = null;
    public string $title = '';
    public string $description = '';
    public $price = 0;
    public string $type = TrainingCalendar::TYPE_ONLINE;
    public string $venue = '';
    public string $registration_deadline = '';
    public string $event_datetime = '';
    public $max_seats = 50;
    public string $status = TrainingCalendar::STATUS_DRAFT;

    protected TrainingCalendarService $service;

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    public function mount(?int $trainingId = null): void
    {
        $this->trainingId = $trainingId;

        if ($trainingId) {
            $training = $this->service->getTraining($trainingId);

            if (empty($training) || $training->tutor_id !== Auth::id()) {
                abort(404);
            }

            $this->title = $training->title;
            $this->description = $training->description ?? '';
            $this->price = $training->price;
            $this->type = $training->type;
            $this->venue = $training->venue ?? '';
            $this->registration_deadline = $training->registration_deadline?->format('Y-m-d\TH:i') ?? '';
            $this->event_datetime = $training->event_datetime?->format('Y-m-d\TH:i') ?? '';
            $this->max_seats = $training->max_seats;
            $this->status = $training->status;
        } else {
            $this->max_seats = (int) trainingCalendarSetting('default_max_seats', 50);
        }
    }

    public function save(): void
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:online,offline',
            'registration_deadline' => 'required|date',
            'event_datetime' => 'required|date|after:registration_deadline',
            'max_seats' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,cancelled',
        ];

        if ($this->type === TrainingCalendar::TYPE_OFFLINE) {
            $rules['venue'] = 'required|string|max:255';
        }

        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type,
            'venue' => $this->type === TrainingCalendar::TYPE_OFFLINE ? $this->venue : null,
            'registration_deadline' => $this->registration_deadline,
            'event_datetime' => $this->event_datetime,
            'max_seats' => $this->max_seats ?: (int) trainingCalendarSetting('default_max_seats', 50),
            'status' => $this->status,
        ];

        if ($this->trainingId) {
            $training = $this->service->getTraining($this->trainingId);
            $this->service->updateTraining($training, $data);
        } else {
            $this->service->createTraining($data, Auth::id());
        }

        $this->dispatch('showAlertMessage', type: 'success', message: __('trainingcalendar::trainingcalendar.training_saved'));
        $this->redirect(route('trainingcalendar.tutor.trainings'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('trainingcalendar::livewire.tutor.create-training');
    }
}
