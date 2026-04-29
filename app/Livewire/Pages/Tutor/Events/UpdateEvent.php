<?php

namespace App\Livewire\Pages\Tutor\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class UpdateEvent extends Component
{
    use WithFileUploads;

    public $event;
    public $title;
    public $date_time;
    public $sort_date;
    public $mode;
    public $banner_image;
    public $old_banner_image;
    public $venue_address;
    public $venue_city;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'date_time' => 'nullable|string|max:255',
            'sort_date' => 'nullable|date',
            'mode' => 'required|in:Virtual,Physical',
            'banner_image' => 'nullable|image|max:1024',
            'venue_address' => $this->mode === 'Physical' ? 'required|string|max:255' : 'nullable',
            'venue_city' => $this->mode === 'Physical' ? 'required|string|max:255' : 'nullable',
        ];
    }

    public function mount($id)
    {
        $this->event = Event::where('user_id', Auth::id())->findOrFail($id);
        $this->title = $this->event->title;
        $this->date_time = $this->event->date_time;
        $this->sort_date = $this->event->sort_date ? $this->event->sort_date->format('Y-m-d\TH:i') : null;
        $this->mode = $this->event->mode ?? 'Virtual';
        $this->old_banner_image = $this->event->banner_image;
        $this->venue_address = $this->event->venue_address;
        $this->venue_city = $this->event->venue_city;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.tutor.events.update-event');
    }

    public function update()
    {
        $this->validate();

        $eventData = [
            'title' => $this->title,
            'date_time' => $this->date_time,
            'sort_date' => $this->sort_date,
            'mode' => $this->mode,
            'venue_address' => $this->mode === 'Physical' ? $this->venue_address : null,
            'venue_city' => $this->mode === 'Physical' ? $this->venue_city : null,
        ];

        if ($this->banner_image) {
            $eventData['banner_image'] = $this->banner_image->store('events', 'public');
        }

        $this->event->update($eventData);

        $this->dispatch('showAlertMessage', type: 'success', message: 'Event updated successfully');
        return redirect()->route('tutor.events.index');
    }
}
