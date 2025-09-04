<?php

namespace App\Http\Requests\Student\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDisputeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $disputeReasons = collect(setting('_dispute_setting.dispute_reasons') ?? [])
        ->pluck('dispute_reason')
        ->toArray();
        
        return [
            'reason' => ['required', 'string', Rule::in($disputeReasons)],
            'description' => 'required|string'
        ];
    }

    public function messages() {
        return [
            'required'  => __('validation.required_field'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'description'    => sanitizeTextField($this->description)
        ]);
    }
}
