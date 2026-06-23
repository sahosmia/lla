<?php

namespace Modules\Courses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursePrerequisitesRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'prerequisites' => 'nullable|string',
        ];
    }
}
