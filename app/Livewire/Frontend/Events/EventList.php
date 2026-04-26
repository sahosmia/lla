<?php

namespace App\Livewire\Frontend\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class EventList extends Component
{
    use WithPagination;

    public $perPage = 12;

    #[Layout('layouts.frontend-app')]
    public function render()
    {
        $events = Event::with('trainer.profile')
            ->orderByRaw('sort_date IS NULL, sort_date ASC')
            ->paginate($this->perPage);

        return view('livewire.frontend.events.event-list', compact('events'));
    }
}
