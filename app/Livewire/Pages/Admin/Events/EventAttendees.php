<?php

namespace App\Livewire\Pages\Admin\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class EventAttendees extends Component
{
    use WithPagination;

    public $event;
    public $search = '';
    public $perPage = 10;

    public function mount($id)
    {
        $this->event = Event::findOrFail($id);

        // Security Check: If user is tutor, they can only view attendees for their own events
        if (Auth::user()->hasRole('tutor') && $this->event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to event attendees.');
        }
    }

    public function render()
    {
        $attendees = \DB::table('event_user')
            ->where('event_id', $this->event->id)
            ->where(function ($query) {
                $query->where('email', 'LIKE', "%$this->search%")
                      ->orWhere('name', 'LIKE', "%$this->search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $layout = Auth::user()->hasRole('admin') ? 'layouts.admin-app' : 'layouts.app';

        return view('livewire.pages.admin.events.event-attendees', compact('attendees'))
            ->layout($layout);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
