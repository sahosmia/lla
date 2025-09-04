<?php

namespace App\Http\Requests\Student\Booking;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'rating'    => 'required|integer|in:1,2,3,4,5',
            'comment'   => 'required|string|max:16777215'
        ];
    }

    public function messages() {
        return [
            'rating'    => __('validation.required_field'),
            'required'  => __('validation.required_field'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'comment'       => sanitizeTextField($this->comment),
        ]);
    }
}
