<?php

namespace App\Http\Requests\Student\BillingDetail;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class BillingDetailStoreRequest extends BaseFormRequest
{

    protected $enableGooglePlaces;

    public function __construct()
    {
        $this->enableGooglePlaces  = setting('_api.enable_google_places') ?? '0';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName'             => 'required|string|max:100',
            'lastName'              => 'required|string|max:100',
            'phone'                 => 'nullable|regex:/^(\+?\(?\d{1,4}\)?)?[\d\s\-]{7,15}$/',
            'email'                 => 'required|email',
            'company'               => 'required|string|max:255',
            'lat'                   => $this->enableGooglePlaces == "1" ? 'required|numeric|regex:/^-?\d{1,9}(\.\d{1,6})?$/' : 'nullable',
            'lng'                   => $this->enableGooglePlaces == "1" ? 'required|numeric|regex:/^-?\d{1,9}(\.\d{1,6})?$/' : 'nullable',
            'country'               => $this->enableGooglePlaces != "1" ? 'required|numeric' : 'nullable|string',
            'zipcode'               => $this->enableGooglePlaces != '1' ? 'required|regex:/^[A-Za-z0-9\s\-]{3,10}$/' : 'nullable',
            'city'                  => $this->enableGooglePlaces != '1'  ? 'required|string|max:255' : 'nullable|string',
            'address'               => $this->enableGooglePlaces == '1' ? 'required|string|max:255' : 'nullable|string',
        ];
    }
    public function messages()
    {
        return [
            'required'              => __('general.required_field'),
            'email'                 => __('general.invalid_email'),
            'required_with'         => __('general.required_field'),
            'zipcode.regex'         => __('general.invalid_zipcode'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'firstName'                => sanitizeTextField($this->firstName),
            'lastName'                 => sanitizeTextField($this->lastName),
            'company'                  => sanitizeTextField($this->company),
            'city'                     => sanitizeTextField($this->city),
            'address'                  => sanitizeTextField($this->address),
        ]);
    }
}
