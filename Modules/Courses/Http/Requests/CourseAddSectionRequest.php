<?php

namespace Modules\Courses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseAddSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'course_id'         => 'required|exists:' . config('courses.db_prefix') . 'courses,id',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'course_id'         => 'course',
            'title'             => 'section title',
            'description'       => 'section description',
        ];
    }
}
