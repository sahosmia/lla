<?php

namespace Modules\Courses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseFaqsRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'question' => 'required|string|max:255',
            'answer'   => 'required|string|max:65535 ',
        ];
    }
}
