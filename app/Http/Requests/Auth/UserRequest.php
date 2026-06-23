<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class UserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return false;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    public function rules() {
        return [
            'first_name'         => 'required|string|min:3|max:255',
            'last_name'          => 'required|string|min:3|max:255',
            'email'              => 'required|string|email|max:255|unique:users',
            'userRole'           => 'required|string|min:3|max:255',
            'password'           => ['required',Rules\Password::defaults()],
            'confirm_password'   => ['required','same:password',Rules\Password::defaults()],
        ];
    }

    public function messages() {
        return [
            // 'required' => trans('general.required_field')
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
