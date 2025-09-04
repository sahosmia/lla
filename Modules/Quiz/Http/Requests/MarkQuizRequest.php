<?php

namespace Modules\Quiz\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class MarkQuizRequest extends BaseFormRequest
{
    public function prepareForValidation()
    {
        if ($this->has('requiredAnswers')) {
            $answers = $this->input('requiredAnswers');

            foreach ($answers as $index => $answer) {
                if (isset($answer['question_id'])) {
                    $question = \Modules\Quiz\Models\Question::find($answer['question_id']);
                    if ($question) {
                        $answers[$index]['maximum_marks'] = $question->points;
                    }
                }
            }

            $this->merge([
                'requiredAnswers' => $answers,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'requiredAnswers.*.question_id'     => 'required',
            'requiredAnswers.*.marks_awarded'   => 'required|numeric|gte:0|lte:requiredAnswers.*.maximum_marks',
        ];
    }


    public function messages()
    {
        return [
            'requiredAnswers.*.marks_awarded.required'      => 'The points are required',
            'requiredAnswers.*.marks_awarded.numeric'       => 'The points must be a number',
            'requiredAnswers.*.marks_awarded.gte'           => 'The points must be greater than or equal to 0',
            'requiredAnswers.*.marks_awarded.lte'           => 'The points must be less than or equal to maximum points',
        ];
    }
}
