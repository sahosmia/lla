<?php

namespace App\Livewire\Pages\Admin\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class EventAttendees extends Component
{
    use WithPagination;

    public $event;
    public $search = '';
    public $perPage = 10;

    public function mount($id)
    {
        $this->event = Event::findOrFail($id);
    }

    #[Layout('layouts.admin-app')]
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

        return view('livewire.pages.admin.events.event-attendees', compact('attendees'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
