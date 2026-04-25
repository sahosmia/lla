<?php

namespace App\Http\Requests\Student\Order;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName'             => 'required|string|max:150',
            'lastName'              => 'required|string|max:150',
            'paymentMethod'         => 'required|string|max:150',
            'phone'                 => 'nullable|regex:/^(\+?\(?\d{1,4}\)?)?[\d\s\-]{7,15}$/',
            'email'                 => 'required|email',
            'country'               => 'required|string|max:150',
            'state'                 => 'required|string|max:255',
            'zipcode'               => 'required|regex:/^[A-Za-z0-9\s\-]{3,10}$/',
            'city'                  => 'required|string|max:150',
        ];
    }

    public function messages()
    {
        return [
            'required'                  => __('general.required_field'),
            'paymentMethod.required'    => __('general.method_required'),
            'email'                     => __('general.invalid_email'),
            'required_with'             => __('general.required_field'),
            'zipcode.regex'             => __('general.invalid_zipcode'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'firstName'             => sanitizeTextField($this->firstName),
            'lastName'              => sanitizeTextField($this->lastName),
            'paymentMethod'         => sanitizeTextField($this->paymentMethod),
            'company'               => sanitizeTextField($this->company),
            'country'               => sanitizeTextField($this->country),
            'state'                 => sanitizeTextField($this->state),
            'city'                  => sanitizeTextField($this->city),
        ]);
    }
}
