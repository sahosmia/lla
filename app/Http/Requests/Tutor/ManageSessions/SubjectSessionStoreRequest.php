<?php

namespace App\Http\Requests\Tutor\ManageSessions;

use Illuminate\Foundation\Http\FormRequest;

class SubjectSessionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() {
        return [
            'start_time'                    => 'required_if:action,add',
            'end_time'                      => 'required_if:action,add|after:start_time',
            'spaces'                        => 'sometimes|required|integer|min:1',
            'session_fee'                   => 'required|numeric',
            'description'                   => 'required|string|max:65535',
            'meeting_link'                  => 'nullable|url:http,https'
        ];
    }

    public function messages() {
        return [
            'start_time.required_if'        => __('validation.required_field'),
            'spaces.required_if'            => __('validation.required_field'),
            'end_time.required_if'          => __('validation.required_field'),
            'required'                      => __('validation.required_field'),
            'end_time.after'                => __('validation.time_range_error'),
            'meeting_link'                  => __('validation.active_url')
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'description'               => sanitizeTextField($this->description, keep_linebreak:true),
        ]);
    }

}
