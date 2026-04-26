<?php

namespace App\Livewire\Components;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UpcomingEvents extends Component
{
    public $eventsLimit;

    public function mount($eventsLimit = 4)
    {
        $this->eventsLimit = $eventsLimit;
    }

    public function render()
    {
        $events = Event::with('trainer.profile')
            ->orderByRaw('sort_date IS NULL, sort_date ASC')
            ->limit($this->eventsLimit)
            ->get();

        return view('livewire.components.upcoming-events', compact('events'));
    }
}
