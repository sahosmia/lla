<?php

namespace App\Livewire\Pages\Admin\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Events extends Component
{
    use WithPagination;

    public $search = '';
    public $sortby = 'desc';
    public $perPage = 10;
    public $selectedEvents = [];
    public $selectAll = false;

    public function mount()
    {
        $this->perPage = setting('_general.per_page_record') ?? 10;
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.events.events', [
            'events' => $this->events
        ]);
    }

    #[Computed()]
    public function events()
    {
        $events = Event::with('trainer.profile');

        if (!empty($this->search)) {
            $events = $events->where('title', 'LIKE', "%$this->search%");
        }

        return $events->orderBy('id', $this->sortby)->paginate($this->perPage);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedEvents = $this->events->pluck('id')->toArray();
        } else {
            $this->selectedEvents = [];
        }
    }

    #[On('delete-event')]
    public function delete($params = [])
    {
        if (!empty($params['id'])) {
            Event::findOrFail($params['id'])->delete();
            $message = 'Event deleted successfully';
        } elseif (!empty($this->selectedEvents)) {
            Event::whereIn('id', $this->selectedEvents)->delete();
            $message = 'Events deleted successfully';
        }

        $this->selectedEvents = [];
        $this->dispatch('showAlertMessage', type: 'success', message: $message);
    }
}
