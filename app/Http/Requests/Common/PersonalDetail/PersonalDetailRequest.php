<?php

namespace App\Http\Requests\Common\PersonalDetail;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Facades\Auth;

class PersonalDetailRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $enableGooglePlaces             = setting('_api.enable_google_places') ?? '0';
        $isProfilePhoneMendatory        = setting('_lernen.profile_phone_number') == 'yes' ? true : false;
        $isProfileVideoMendatory        = setting('_lernen.profile_video') == 'yes' ? true : false;
        $isProfileKeywordsMendatory     = setting('_lernen.profile_keywords') == 'yes' ? true : false;
        $rules = [
            'first_name'        => 'required|string|min:3|max:150',
            'phone_number'      => $isProfilePhoneMendatory ? 'required|regex:/^(\+?\(?\d{1,4}\)?)?[\d\s\-]{7,15}$/' : 'nullable|regex:/^(\+?\(?\d{1,4}\)?)?[\d\s\-]{7,15}$/',
            'last_name'         => 'sometimes|string|min:3|max:150',
            'gender'            => 'required|in:male,female,not_specified',
            'user_languages'    => 'required|array|min:1',
            'native_language'   => 'required|string:max:255',
            'description'       => 'required|string|min:20|max:65535',
            'email'             => 'required|email|max:255',
            'image'             => 'required',
        ];

        if (Auth::user()->role == 'tutor') {
            $rules['intro_video'] = $isProfileVideoMendatory ? 'required' : 'nullable';
            $rules['tagline']     = 'required|string|min:20|max:255';
            $rules['keywords']    = 'nullable|string|max:255';
            $socialPlatforms    = setting('_social.platforms');

            if (!empty($socialPlatforms) && is_array($socialPlatforms)) {
                $rules['social_profiles'] = 'nullable|array';
                foreach ($socialPlatforms as $profile) {
                    if ($profile == 'WhatsApp') {
                        $rules["social_profiles.{$profile}"] = 'nullable|regex:/^(\+?\(?\d{1,4}\)?)?[\d\s\-]{7,15}$/';
                    } else {
                        $rules["social_profiles.{$profile}"] = 'nullable|url|max:255';
                    }
                }
            }
        }

        if ($enableGooglePlaces != '1') {
            $rules['country']   = 'required|numeric';
            $rules['city']      = 'required|string|max:255';
            $rules['zipcode']   = 'required|regex:/^[A-Za-z0-9\s\-]{3,10}$/';
        } else {
            $rules['address']   = 'required|string|max:255';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'required'      => __('validation.required_field'),
            'email'         => __('validation.invalid_email'),
            'zipcode.regex' => __('general.invalid_zipcode'),

        ];

        $socialPlatforms = setting('_social.platforms');

        if (!empty($socialPlatforms) && is_array($socialPlatforms)) {
            foreach ($socialPlatforms as $platform) {
                if ($platform == 'WhatsApp') {  
                    $messages["social_profiles.{$platform}.regex"] = __('validation.valid_phone_number', ['attribute' => $platform]);
                } else {
                    $messages["social_profiles.{$platform}.url"] = __('validation.valid_url', ['attribute' => $platform]);
                }
            }
        }

        return $messages;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name'                => sanitizeTextField($this->first_name),
            'last_name'                 => sanitizeTextField($this->last_name),
            'native_language'           => sanitizeTextField($this->native_language),
            'description'               => sanitizeTextField($this->description, keep_linebreak: true),
            'city'                      => sanitizeTextField($this->city),
            'address'                   => sanitizeTextField($this->address),
        ]);
    }
}
