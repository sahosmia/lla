<?php

namespace Modules\Quiz\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AiQuizRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'description'    => 'required|string',
            'question_types' => 'required|array|min:1',
        ];

        foreach ($this->input('question_types', []) as $key => $value) {
            $max = setting('_quiz.max_number_of_' . $key . '_questions_by_ai') ?? 0;
            $rules['question_types.' . $key] = "nullable|integer|between:0,{$max}";
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'description.required'        => __('quiz::quiz.description_required'),
            'description.string'          => __('quiz::quiz.description_string'),

            'question_types.required'     => __('quiz::quiz.question_types_required'),
            'question_types.array'        => __('quiz::quiz.question_types_required'),
            'question_types.min'          => __('quiz::quiz.question_types_required'),
            'question_types.*.integer'    => __('quiz::quiz.question_types_integer'),
        ];


        foreach ($this->input('question_types', []) as $key => $value) {
            $max = setting('_quiz.max_number_of_' . $key . '_questions_by_ai') ?? 0;
            $messages["question_types.{$key}.between"] = __('quiz::quiz.question_types_out_of_range', ['max' => $max]);
        }

        return $messages;
    }
}
