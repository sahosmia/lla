<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class AdminUserRequest extends FormRequest {
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    public function rules($adminId) {
        return [
            'first_name'         => 'required|string|min:3|max:255',
            'last_name'          => 'required|string|min:3|max:255',
            'email'              => 'required|string|email|max:255|unique:users,email,' . $adminId,
            'permissions'        => 'required|array|min:1',
            'password'           => empty($adminId) ? ['required',Rules\Password::defaults()] : ['nullable',Rules\Password::defaults()],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'first_name'        => sanitizeTextField($this->first_name),
            'last_name'         => sanitizeTextField($this->last_name),
        ]);
    }
}
