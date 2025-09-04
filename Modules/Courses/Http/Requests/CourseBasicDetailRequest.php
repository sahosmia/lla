<?php

namespace Modules\Courses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseBasicDetailRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'                 => 'required|string|max:255|min:3',
            'subtitle'              => 'required|string|max:255|min:3',
            'description'           => 'required|string|min:3',
            'category_id'           => 'required|exists:'.config('courses.db_prefix').'categories,id',
            'sub_category_id'       => 'required|exists:'.config('courses.db_prefix').'categories,id',
            'tags'                  => 'nullable|array',
            'tags.*'                => 'required|string',
            'type'                  => 'required|in:video,audio,live,article,all',
            'level'                 => 'required|in:beginner,intermediate,expert,all',
            'language_id'           => 'required|exists:languages,id',
            'learning_objectives'   => 'nullable|array',
            'learning_objectives.*' => 'string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'type'              => 'course type',
            'category_id'       => 'category',
            'sub_category_id'   => 'sub category',
            'language_id'       => 'language',
        ];
    }
}
