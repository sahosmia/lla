<?php

namespace App\Livewire\Forms\Student\Booking;

use App\Http\Requests\Student\Booking\ReviewStoreRequest;
use App\Traits\PrepareForValidation;
use Livewire\Form;

class RatingForm extends Form
{
    use PrepareForValidation;
    public $rating          = 0;
    public $comment         = '';
    public $bookingId       = null;

    public function rules(){

        $request = new ReviewStoreRequest();
        return $request->rules();
    }

    public function messages() {

        $request = new ReviewStoreRequest();
        return $request->messages();
    }

    public function validateData() {
        $this->beforeValidation();
        return $this->validate();
    }
}
