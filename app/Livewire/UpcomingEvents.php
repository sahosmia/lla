<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class UpcomingEvents extends Component
{
    public $limit = 6;

    public function mount($limit = 6)
    {
        $this->limit = $limit;
    }

    public function register($eventId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        if (!$user->events()->where('event_id', $eventId)->exists()) {
            $user->events()->attach($eventId);
        }

        if (!empty($event->registration_link)) {
            return redirect()->away($event->registration_link);
        }
    }

    public function render()
    {
        $events = Event::latest()->limit($this->limit)->get();
        return view('livewire.upcoming-events', [
            'events' => $events
        ]);
    }
}
