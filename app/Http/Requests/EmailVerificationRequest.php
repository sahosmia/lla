<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class EmailVerificationRequest extends FormRequest
{
    public function authorize()
    {
        $user = User::find($this->route('id'));

        if (!$user) {
            return false;
        }
        
        if (! hash_equals((string) $user->getKey(), (string) $this->route('id'))) {
            return false;
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $this->route('hash'))) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return [];
    }
}
