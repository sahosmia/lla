<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class ContactForm extends Component
{
    public $fullname;
    public $organization;
    public $designation;
    public $email;
    public $phone;
    public $type = '';
    public $message;
    public $successMessage;

    protected $rules = [
        'fullname' => 'required|min:3',
        'organization' => 'required',
        'designation' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'type' => 'required',
        'message' => 'required|min:10',
    ];

    public function submit()
    {
        $this->validate();

        // In a real application, you might want to send an email or save to database.
        // For now, we will just show a success message.

        $this->successMessage = __('Your inquiry has been submitted successfully. We will get back to you soon.');

        $this->reset(['fullname', 'organization', 'designation', 'email', 'phone', 'type', 'message']);
    }

    public function render()
    {
        return view('livewire.frontend.contact-form');
    }
}
