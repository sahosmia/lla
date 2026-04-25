<?php

namespace App\Livewire\Forms\Admin\User;
use App\Http\Requests\Auth\UserRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class UserForm extends Form
{

    public $first_name, $last_name, $email, $userRole = 'tutor', $password, $confirm_password,$user;

    private ?UserRequest $userRequest = null;

    public function boot()
    {
        $this->user                 = Auth::user();
        $this->userRequest          = new UserRequest();
    }

    public function rules(): array
    {

        return $this->userRequest->rules();
    }

    public function messages(): array
    {

            return $this->userRequest->messages();
    }

    public function updateInfo()
    {
        $this->validate($this->rules(), $this->messages());
    }
}
