<?php

namespace App\Livewire\Forms\Admin\ManageAdmin;
use App\Http\Requests\Auth\AdminUserRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class AdminUserForm extends Form
{

    public $first_name, $last_name, $email, $password,$user,$permissions = [],$adminId;

    private ?AdminUserRequest $adminUserRequest = null;

    public function boot()
    {
        $this->user                 = Auth::user();
        $this->adminUserRequest     = new AdminUserRequest();
    }

    public function rules(): array
    {

        return $this->adminUserRequest->rules($this->adminId);
    }

    public function updateInfo()
    {
        $this->validate($this->rules());
    }
}
