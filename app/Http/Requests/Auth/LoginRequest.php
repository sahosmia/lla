<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    use ApiResponser;

     public function failedValidation(Validator $validator) {

        throw new HttpResponseException($this->error('Validation errors', $validator->errors()));
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'email'         => ['required', 'string', 'email'],
            'password'      => ['required', 'string'],
        ];
    }
}
