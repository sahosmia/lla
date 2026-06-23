<?php

namespace Modules\TrainingCalendar\Livewire\Pages\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\TrainingCalendar\Models\TrainingRegistration;

class RegistrationListing extends Component
{
    use WithPagination;

    public string $keyword = '';

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $registrations = TrainingRegistration::query()
            ->where('payment_status', TrainingRegistration::PAYMENT_PAID)
            ->with(['training.tutor.profile', 'user.profile'])
            ->when($this->keyword, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->keyword . '%')
                        ->orWhere('email', 'like', '%' . $this->keyword . '%')
                        ->orWhereHas('training', fn ($t) => $t->where('title', 'like', '%' . $this->keyword . '%'));
                });
            })
            ->latest()
            ->paginate(10);

        return view('trainingcalendar::livewire.admin.registration-listing', compact('registrations'));
    }
}
