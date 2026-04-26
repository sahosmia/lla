<?php

namespace App\Livewire\Pages\Admin\Events;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class UpdateEvent extends Component
{
    use WithFileUploads;

    public $event;
    public $title;
    public $date_time;
    public $sort_date;
    public $mode;
    public $user_id;
    public $banner_image;
    public $old_banner_image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'date_time' => 'nullable|string|max:255',
        'sort_date' => 'nullable|date',
        'mode' => 'nullable|string|max:255',
        'user_id' => 'nullable|exists:users,id',
        'banner_image' => 'nullable|image|max:1024',
    ];

    public function mount($id)
    {
        $this->event = Event::findOrFail($id);
        $this->title = $this->event->title;
        $this->date_time = $this->event->date_time;
        $this->sort_date = $this->event->sort_date ? $this->event->sort_date->format('Y-m-d\TH:i') : null;
        $this->mode = $this->event->mode;
        $this->user_id = $this->event->user_id;
        $this->old_banner_image = $this->event->banner_image;
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $tutors = User::role('tutor')->with('profile')->get();
        return view('livewire.pages.admin.events.update-event', compact('tutors'));
    }

    public function update()
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

        $this->event->update($eventData);

        $this->dispatch('showAlertMessage', type: 'success', message: 'Event updated successfully');
        return redirect()->route('events.index');
    }
}
