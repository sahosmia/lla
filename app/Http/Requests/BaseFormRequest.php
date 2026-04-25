<?php

namespace App\Http\Requests;

use App\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{

    use ApiResponser;

    public function failedValidation(Validator $validator) {

       throw new HttpResponseException($this->validationError('Validation errors', $validator->errors()));
   }

}
