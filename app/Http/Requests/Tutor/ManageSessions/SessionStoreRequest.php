<?php

namespace App\Http\Requests\Tutor\ManageSessions;

use Illuminate\Foundation\Http\FormRequest;

class SessionStoreRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'subject_group_id'              => 'required|integer|gt:0',
            'date_range'                    => 'required',
            'start_time'                    => 'required',
            'end_time'                      => 'required|after:start_time',
            'spaces'                        => 'required|integer|min:1',
            'session_fee'                   => isPaidSystem() ? 'required|numeric' : 'nullable',
            'duration'                      => 'required',
            'break'                         => 'required',
            'recurring_days'                => 'nullable',
            'description'                   => 'required',
        ];
    }

    public function messages() {
        return [
            'required'                      => __('validation.required_field'),
            'end_time'                      => __('validation.time_range_error')
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'description'                => sanitizeTextField($this->description, keep_linebreak: true),
        ]);
    }
}
