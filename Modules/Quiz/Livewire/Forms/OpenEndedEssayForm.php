<?php

namespace Modules\Quiz\Livewire\Forms;

use App\Traits\PrepareForValidation;
use Livewire\Form;
use Modules\Quiz\Http\Requests\QuestionTypes\OpenEndedEssayRequest;

class OpenEndedEssayForm extends Form
{
    use PrepareForValidation;

    public $type                    = '';
    public $question_title          = '';
    public $question_text           = '';

    private ?OpenEndedEssayRequest $request = null;

    public function boot()
    {
        $this->request = new OpenEndedEssayRequest();
    }


    public function rules()
    {
        return $this->request->rules();
    }

    public function messages()
    {
        return $this->request->messages();
    }

    public function attributes()
    {
        return $this->request->attributes();
    }


    public function saveQuestion()
    {
        $this->beforeValidation();
        $this->validate($this->request->rules(), $this->request->messages(), $this->request->attributes());

        return [
            'title'               => $this->question_title,
            'description'         => $this->question_text,
        ];
    }

    public function setQuestion($question)
    {
        $this->question_title       = $question['title'] ?? '';
        $this->question_text        = $question['description'] ?? '';
    }
}
