<?php

namespace App\Livewire\Forms\Tutor\ManageSessions;

use App\Http\Requests\Tutor\ManageSessions\SubjectSessionStoreRequest;
use App\Traits\PrepareForValidation;
use Livewire\Form;

class SubjectSessionStoreForm extends Form
{

    use PrepareForValidation;
    public $start_time      = '';
    public $end_time        = '';
    public $spaces          = 1;
    public $session_fee     = 0;
    public $description;
    public $action          = '';
    public $meeting_link    = '';
    public $allowed_for_subscriptions = 0;
    public $template_id     = null;
    public $assign_quiz_certificate     = 'any';

    public function rules(){
        $request = new SubjectSessionStoreRequest();
        return $request->rules();
    }

    public function messages() {
        $request = new SubjectSessionStoreRequest();
        return $request->messages();
    }

    public function validateData() {
        $this->beforeValidation();
        return $this->validate();
    }
}
