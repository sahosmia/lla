<?php

namespace Modules\Quiz\Http\Requests\QuestionTypes;

use App\Http\Requests\BaseFormRequest;

class McqRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_title'                => 'required|string|max:255',
            'question_text'                 => 'nullable|string|max:65535',
            'mcqs'                          => 'required|array|min:2',
            'correct_answer'                => 'required|numeric',
            'mcqs.*.option_text'            => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'mcqs.*.option_text.required'  => __('quiz::quiz.option_required'),
            'correct_answer.required'      => __('quiz::quiz.correct_answer_required'),
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
            'question_text'             => __('quiz::quiz.question_description'),
            'mcqs.*.option_text'        => __('quiz::quiz.option'),
            'mcqs'                      => __('quiz::quiz.options'),
        ];
    }
}
