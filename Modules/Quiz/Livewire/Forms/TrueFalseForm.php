<?php

namespace Modules\Quiz\Livewire\Forms;

use App\Traits\PrepareForValidation;
use Livewire\Form;
use Modules\Quiz\Http\Requests\QuestionTypes\TrueFalseRequest;
use Modules\Quiz\Services\QuestionService;

class TrueFalseForm extends Form
{
    use PrepareForValidation;

    public $question_title          = '';
    public $correct_answer          = null;

    private ?TrueFalseRequest $request = null;

    public function boot()
    {
        $this->request = new TrueFalseRequest();
    }


    public function rules()
    {
        return $this->request->rules();
    }

    public function attributes()
    {
        return $this->request->attributes();
    }


    public function saveQuestion()
    {
        $this->validate($this->request->rules(), $this->request->messages(), $this->request->attributes());

        $options = [
            [
                'option_text'  => 'True',
                'is_correct'    => $this->correct_answer == "true"
            ],
            [
                'option_text'  => 'False',
                'is_correct'    => $this->correct_answer == "false"
            ],
        ];

        return [
            'title'             => $this->question_title,
            'options'           => $options
        ];
    }


    public function setQuestion($question)
    {

        foreach ($question->options as $option) {
            if ($option->is_correct == 1) {
                $this->correct_answer = $option->option_text == 'True' ? 'true' : 'false';
                break;
            }
        }

        $this->question_title       = $question['title'] ?? '';
    }
}
