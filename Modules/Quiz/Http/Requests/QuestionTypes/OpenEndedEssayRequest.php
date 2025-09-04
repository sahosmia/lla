<?php

namespace Modules\Quiz\Http\Requests\QuestionTypes;

use Illuminate\Foundation\Http\FormRequest;

class OpenEndedEssayRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            //
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
            'question_text' => 'question description',
        ];
    }
}
