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

    public function register()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$this->event->users()->where('user_id', $user->id)->exists()) {
            $this->event->users()->attach($user->id);
            $this->dispatch('showAlertMessage', type: 'success', message: 'Successfully registered for the event');
        } else {
            $this->dispatch('showAlertMessage', type: 'info', message: 'You are already registered for this event');
        }
    }
}
