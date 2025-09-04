<?php

namespace App\Http\Requests\Tutor\Education;

use App\Http\Requests\BaseFormRequest;

class EducationStoreRequest extends BaseFormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'course_title'              => 'required|string|max:255',
            'institute_name'            => 'required|string',
            'country'                   => 'required|numeric|gt:0',
            'city'                      => 'required|string|max:255',
            'start_date'                => 'required|date',
            'end_date'                  => 'required_if:ongoing,false|nullable|date|after:start_date',
            'description'               => 'required|string|min:10',
            'ongoing'                   => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'required'                  => __('general.required_field'),
            'end_date.required_if'      => __('calendar.date_range_error'),
            'end_date.after'            => __('calendar.date_range_error'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'course_title'              => sanitizeTextField($this->course_title),
            'institute_name'            => sanitizeTextField($this->institute_name),
            'city'                      => sanitizeTextField($this->city),
            'description'               => sanitizeTextField($this->description, keep_linebreak: true),
        ]);
    }

}
