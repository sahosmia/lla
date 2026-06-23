<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Student;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\TrainingCalendar\Models\TrainingRegistration;

class TrainingDetail extends Component
{
    public TrainingRegistration $registration;

    public function mount(int $registrationId): void
    {
        $registration = TrainingRegistration::query()
            ->where('id', $registrationId)
            ->where('user_id', Auth::id())
            ->where('payment_status', TrainingRegistration::PAYMENT_PAID)
            ->with(['training.tutor.profile', 'training.notices' => fn ($q) => $q->latest()])
            ->firstOrFail();

        $this->registration = $registration;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('trainingcalendar::livewire.student.training-detail');
    }
}
