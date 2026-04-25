<?php

namespace Modules\Quiz\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class QuizRequest extends BaseFormRequest
{

    public $quizzable_type;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'quizzable_type'    => 'required|string', 
            'quizzable_id'      => 'required|integer',
            'title'             => 'required|string|max:255',
            'description'       => 'string',
        ];
        if ($this->quizzable_type == 'App\Models\UserSubjectGroupSubject') {
            $rules['user_subject_slots'] = 'required';
        } else {
            $rules['user_subject_slots'] = 'nullable';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'quizzable_type'            =>  __('quiz::quiz.quiz_type_requied'),
            'quizzable_id'              =>  __('quiz::quiz.quizzable_id'),
            'user_subject_slots'        =>  __('general.required_field'),
        ];
    }
}
