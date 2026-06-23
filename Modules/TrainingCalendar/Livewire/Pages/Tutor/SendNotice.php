<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Tutor;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class SendNotice extends Component
{
    public int $trainingId;
    public string $subject = '';
    public string $message = '';
    public string $zoom_link = '';
    public string $meet_link = '';
    public string $location = '';

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
        $this->subject = $training->title . ' - Training Notice';
        $this->location = $training->venue ?? '';
    }

    public function send(): void
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $this->validate([
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string',
            'zoom_link' => 'nullable|url|max:500',
            'meet_link' => 'nullable|url|max:500',
            'location' => 'nullable|string|max:255',
        ]);

        $training = $this->service->getTraining($this->trainingId);
        $response = $this->service->sendNotice($training, Auth::user(), [
            'subject' => $this->subject,
            'message' => $this->message,
            'zoom_link' => $this->zoom_link,
            'meet_link' => $this->meet_link,
            'location' => $this->location,
        ]);

        $this->dispatch('showAlertMessage', type: $response['success'] ? 'success' : 'error', message: $response['message']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $training = $this->service->getTraining($this->trainingId);

        return view('trainingcalendar::livewire.tutor.send-notice', compact('training'));
    }
}
