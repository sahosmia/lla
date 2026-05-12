<?php

namespace App\Livewire\Pages\Tutor\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class CreateEvent extends Component
{
    use WithFileUploads;

    public $title;
    public $date_time;
    public $sort_date;
    public $mode = 'Virtual';
    public $banner_image;
    public $venue_address;
    public $venue_city;
    public $price;
    public $registration_deadline;

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
            'price' => 'nullable|numeric|min:0',
            'registration_deadline' => 'nullable|date',
        ];
    }

    #[Layout('layouts.frontend-app')]
    public function render()
    {
        return view('livewire.pages.tutor.events.create-event');
    }

    public function updatedSortDate($value)
    {
        if (empty($this->date_time) && !empty($value)) {
            $this->date_time = \Carbon\Carbon::parse($value)->format('l, d F Y H:i');
        }
    }

    public function save()
    {
        $this->validate();

        $eventData = [
            'title' => $this->title,
            'date_time' => $this->date_time,
            'sort_date' => $this->sort_date,
            'mode' => $this->mode,
            'user_id' => Auth::id(),
            'venue_address' => $this->mode === 'Physical' ? $this->venue_address : null,
            'venue_city' => $this->mode === 'Physical' ? $this->venue_city : null,
            'price' => $this->price,
            'registration_deadline' => $this->registration_deadline,
        ];

        if ($this->banner_image) {
            $eventData['banner_image'] = $this->banner_image->store('events', 'public');
        }

        Event::create($eventData);

        $this->dispatch('showAlertMessage', type: 'success', message: 'Event created successfully');
        return redirect()->route('tutor.events.index');
    }
}
