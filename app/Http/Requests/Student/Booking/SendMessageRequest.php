<?php

namespace App\Http\Requests\Student\Booking;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'message' => 'required|string|max:65535'
        ];
    }

    public function messages() {
        return [
            'required' => __('validation.required_field'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'message'       => sanitizeTextField($this->message, keep_linebreak: true),
        ]);
    }
}
