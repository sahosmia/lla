<?php

namespace Modules\Quiz\Http\Requests\QuestionTypes;

use App\Http\Requests\BaseFormRequest;

class FillInBlanksRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_title'                => ['required', 'string', 'max:255'],
            'blanks.*.option_text'            => 'required|string|max:100',

        ];
    }

    public function messages()
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'blanks.*.option_text' => __('quiz::quiz.option'),
        ];
    }
}
