<?php

namespace App\Livewire\Frontend\Events;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventRegistration extends Component
{
    public $event;
    public $name;
    public $email;
    public $profession;
    public $organization;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'profession' => 'nullable|string|max:255',
        'organization' => 'nullable|string|max:255',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->profile?->full_name ?? $user->name;
            $this->email = $user->email;
            $this->profession = $user->profession;
            $this->organization = $user->organization;
        }
    }

    public function render()
    {
        return view('livewire.frontend.events.event-registration');
    }

    public function register()
    {
        if (Auth::check() && Auth::id() === $this->event->user_id) {
            $this->dispatch('showAlertMessage', type: 'error', message: 'Tutors cannot register for their own events');
            return;
        }

        $this->validate();

        $user = User::where('email', $this->email)->first();

        // Check if already registered by email for this event
        $existing = DB::table('event_user')
            ->where('event_id', $this->event->id)
            ->where('email', $this->email)
            ->exists();

        if (!$existing) {
            DB::table('event_user')->insert([
                'event_id' => $this->event->id,
                'user_id' => $user ? $user->id : null,
                'name' => $this->name,
                'email' => $this->email,
                'profession' => $this->profession,
                'organization' => $this->organization,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->dispatch('showAlertMessage', type: 'success', message: 'Successfully registered for the event');
            $this->dispatch('event-registered');
        } else {
            $this->dispatch('showAlertMessage', type: 'info', message: 'You are already registered for this event');
        }
    }
}
