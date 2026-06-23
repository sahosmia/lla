<?php

namespace App\Livewire\Forms\Tutor\ManageSessions;

use App\Http\Requests\Tutor\ManageSessions\ResheduleSessionStoreRequest;
use Livewire\Form;

class ResheduleSessionForm extends Form
{

    public $date='';
    public $start_time='';
    public $end_time='';
    public $description;
    public $reason;

    public function rules(){
        $request = new ResheduleSessionStoreRequest();
        return $request->rules();
    }

    public function messages() {
        $request = new ResheduleSessionStoreRequest();
        return $request->messages();
    }

    public function validateData() {
        return $this->validate();
    }
}
