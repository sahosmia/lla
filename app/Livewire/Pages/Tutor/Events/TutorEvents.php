<?php

namespace App\Livewire\Pages\Tutor\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class TutorEvents extends Component
{
    use WithPagination;

    public $search = '';
    public $sortby = 'desc';
    public $perPage = 10;

    public function mount()
    {
        $this->perPage = setting('_general.per_page_record') ?? 10;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.tutor.events.tutor-events', [
            'events' => $this->events
        ]);
    }

    #[Computed()]
    public function events()
    {
        $events = Event::where('user_id', Auth::id())->withCount('users');

        if (!empty($this->search)) {
            $events = $events->where('title', 'LIKE', "%$this->search%");
        }

        return $events->orderBy('id', $this->sortby)->paginate($this->perPage);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('delete-event')]
    public function delete($id)
    {
        $event = Event::where('user_id', Auth::id())->findOrFail($id);
        $event->delete();
        $this->dispatch('showAlertMessage', type: 'success', message: 'Training Calendar deleted successfully');
    }
}
