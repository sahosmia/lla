<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Public;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\TrainingCalendar\Models\TrainingCalendar;
use Modules\TrainingCalendar\Services\TrainingCalendarService;

class TrainingDetail extends Component
{
    public ?TrainingCalendar $training = null;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $profession = '';
    public bool $alreadyRegistered = false;

    protected TrainingCalendarService $service;

    public function boot(TrainingCalendarService $service): void
    {
        $this->service = $service;
    }

    public function mount(TrainingCalendar $training): void
    {
        if ($training->status !== TrainingCalendar::STATUS_PUBLISHED) {
            abort(404);
        }

        $this->training = $training->load('tutor.profile')->loadCount('paidRegistrations');

        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->profile?->full_name ?? '';
            $this->email = $user->email ?? '';
            $this->phone = $user->profile?->phone ?? '';
            $this->alreadyRegistered = $this->service->userAlreadyRegistered($training->id, $user->id);
        }
    }

    public function register()
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if (!Auth::check()) {
            $this->dispatch('showAlertMessage', type: 'error', message: __('trainingcalendar::trainingcalendar.login_required'));
            return;
        }

        if (Auth::user()->role !== 'student') {
            $this->dispatch('showAlertMessage', type: 'error', message: __('trainingcalendar::trainingcalendar.student_only'));
            return;
        }

        $this->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'profession' => 'nullable|string|max:150',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profession' => $this->profession,
        ];

        if ($this->training->isFree()) {
            $response = $this->service->registerFree($this->training, $data, Auth::user());
            $this->dispatch('showAlertMessage', type: $response['success'] ? 'success' : 'error', message: $response['message']);

            if ($response['success']) {
                $this->alreadyRegistered = true;
            }

            return;
        }

        $response = $this->service->addToCart($this->training, $data, Auth::user());
        $this->dispatch('showAlertMessage', type: $response['success'] ? 'success' : 'error', message: $response['message']);

        if ($response['success']) {
            return $this->redirect(route('checkout'), navigate: true);
        }
    }

    public function render()
    {
        return view('trainingcalendar::livewire.public.training-detail')
            ->extends('layouts.frontend-app', [
                'pageTitle' => $this->training->title,
                'pageDescription' => $this->training->description,
            ]);
    }
}
