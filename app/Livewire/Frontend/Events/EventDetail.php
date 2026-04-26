<?php

namespace App\Livewire\Frontend\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class EventDetail extends Component
{
    public $event;

    public function mount($id)
    {
        $this->event = Event::with('trainer.profile')->findOrFail($id);
    }

    #[Layout('layouts.frontend-app')]
    public function render()
    {
        return view('livewire.frontend.events.event-detail');
    }
}
