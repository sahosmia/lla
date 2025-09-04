<?php

namespace App\Http\Requests\Common\Identity;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class IdentityStoreRequest extends BaseFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    public function rules() {
        $enableGooglePlaces             = setting('_api.enable_google_places') ?? '0';
        $imageFileExt                   = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $imageFileSize                  = (int) (setting('_general.max_image_size') ?? '5');
        $imageValidation                = 'required|mimes:'.$imageFileExt.'|max:'.$imageFileSize*1024;

        $rules = [
            'name'                      => 'required|min:3|max:100',
            'image'                     => $imageValidation,
            'dateOfBirth'               => 'required',
            'schoolName'                => auth()->user()->role == 'student' ? 'required|max:255' : 'nullable',
            'schoolId'                  => auth()->user()->role == 'student' ? 'required|max:100' : 'nullable',
            'parentName'                => auth()->user()->role == 'student' ? 'required|min:5|max:100' : 'nullable',
            'parentEmail'               => auth()->user()->role == 'student' ? 'required|email|max:100' : 'nullable',
            'parentPhone'               => auth()->user()->role == 'student' ? 'required|numeric|digits:11' : 'nullable',
            'lat'                       => $enableGooglePlaces == "1" ? 'required' : 'nullable',
            'lng'                       => $enableGooglePlaces == "1" ? 'required' : 'nullable',
            'country'                   => $enableGooglePlaces != "1" ? 'required|numeric' : 'nullable|string',
            'zipcode'                   => $enableGooglePlaces != '1' ? 'required|regex:/^[A-Za-z0-9\s\-]{3,10}$/' : 'nullable' ,
            'city'                      => ($enableGooglePlaces != '1') ? 'required|string' : 'nullable|string',
        ];

        $key = auth()->user()->role == 'tutor' ? 'identificationCard' : 'transcript';
        $rules[$key] = $imageValidation;
        return $rules;
    }


    public function messages() {
        $imageFileSize              = setting('_general.max_image_size') ?? '5';
        return [
            'required'              => __('general.required_field'),
            'digits'                => __('validation.invalid_phone'),
            'max'                   => __('validation.max_file_size_err', ['file_size'    => $imageFileSize.'MB']),
            'zipcode.regex'         => __('general.invalid_zipcode'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'name'                  => sanitizeTextField($this->name),
            'schoolName'            => sanitizeTextField($this->schoolName),
            'schoolId'              => sanitizeTextField($this->schoolId),
            'parentName'            => sanitizeTextField($this->parentName),
            'city'                  => sanitizeTextField($this->city),
        ]);
    }
}
