<?php

namespace App\Http\Requests\Tutor\ManageSessions;

use Illuminate\Foundation\Http\FormRequest;

class ResheduleSessionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() {
        return [
            'date'        => 'required|date|after_or_equal:today',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
            'description' => 'required|string|max:65535',
            'reason'      => 'required|string|max:65535',
        ];
    }

    public function messages() {
        return [
            'required' => __('validation.required_field'),
            'end_time' => __('validation.time_range_error')
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'description'                => sanitizeTextField($this->description , keep_linebreak: true),
            'reason'                     => sanitizeTextField($this->reason, keep_linebreak: true),
        ]);
    }
}
