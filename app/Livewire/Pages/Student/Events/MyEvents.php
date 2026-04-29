<?php

namespace App\Livewire\Pages\Student\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class MyEvents extends Component
{
    use WithPagination;

    public $perPage = 10;

    #[Layout('layouts.app')]
    public function render()
    {
        $events = Auth::user()->events()
            ->orderBy('pivot_created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.pages.student.events.my-events', compact('events'));
    }
}
