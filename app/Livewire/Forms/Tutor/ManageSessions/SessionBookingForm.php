<?php

namespace App\Livewire\Forms\Tutor\ManageSessions;

use App\Http\Requests\Tutor\ManageSessions\SessionStoreRequest;
use App\Traits\PrepareForValidation;
use Livewire\Form;

class SessionBookingForm extends Form
{
    use PrepareForValidation;
    public $subject_group_id;
    public $date_range;
    public $start_time='';
    public $end_time='';
    public $duration;
    public $break;
    public $spaces = 1;
    public $recurring_days = [];
    public $session_fee = 0;
    public $description;

    public function rules(){
        $request = new SessionStoreRequest();
        return $request->rules();
    }

    public function messages() {
        $request = new SessionStoreRequest();
        return $request->messages();
    }

    public function setFee($fee) {
        $this->session_fee = $fee;
    }

    public function validateData() {
        $this->beforeValidation(['recurring_days']);
        return $this->validate();
    }
}
