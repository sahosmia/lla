<?php

namespace App\Livewire\Pages\Admin\Events;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class CreateEvent extends Component
{
    use WithFileUploads;

    public $title;
    public $date_time;
    public $sort_date;
    public $mode;
    public $user_id;
    public $banner_image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'date_time' => 'nullable|string|max:255',
        'sort_date' => 'nullable|date',
        'mode' => 'nullable|string|max:255',
        'user_id' => 'nullable|exists:users,id',
        'banner_image' => 'nullable|image|max:1024',
    ];

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $tutors = User::role('tutor')->with('profile')->get();
        return view('livewire.pages.admin.events.create-event', compact('tutors'));
    }

    public function save()
    {
        $this->validate();

        $eventData = [
            'title' => $this->title,
            'date_time' => $this->date_time,
            'sort_date' => $this->sort_date,
            'mode' => $this->mode,
            'user_id' => $this->user_id,
        ];

        if ($this->banner_image) {
            $eventData['banner_image'] = $this->banner_image->store('events', 'public');
        }

        Event::create($eventData);

        $this->dispatch('showAlertMessage', type: 'success', message: 'Event created successfully');
        return redirect()->route('admin.events.index');
    }
}
