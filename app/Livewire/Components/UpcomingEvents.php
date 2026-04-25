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

    public function register($eventId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        if (!$event->users()->where('user_id', $user->id)->exists()) {
            $event->users()->attach($user->id);
            $this->dispatch('showAlertMessage', type: 'success', message: 'Successfully registered for the event');
        } else {
            $this->dispatch('showAlertMessage', type: 'info', message: 'You are already registered for this event');
        }
    }
}
