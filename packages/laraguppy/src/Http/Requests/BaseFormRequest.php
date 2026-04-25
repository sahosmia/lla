<?php

namespace Amentotech\LaraGuppy\Http\Requests;

use Amentotech\LaraGuppy\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{
    use ApiResponser;

    public function failedValidation(Validator $validator) {
        $response = [];
        foreach ($validator->errors()->messages() as $field => $message) {
            $response[$field] = $message[0];
        }
        
        throw new HttpResponseException($this->error('Validation errors', $response, 401));
    }
}
