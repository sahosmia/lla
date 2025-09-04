<?php

namespace Modules\Quiz\Livewire\Forms;

use App\Traits\PrepareForValidation;
use Livewire\WithFileUploads;
use Livewire\Form;
use Modules\Quiz\Http\Requests\QuestionTypes\FillInBlanksRequest;
use Modules\Quiz\Services\QuestionService;

class FillInBlanksForm extends Form
{
    use PrepareForValidation;

    public $question_title      = '';
    public $question_text       = '';
    public $question_id         = null;

    public $blanks  = [['option_text' => '']];




    private ?FillInBlanksRequest $request = null;

    public function boot()
    {
        $this->request = new FillInBlanksRequest();
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

        $blankCount = substr_count(strtoupper($this->question_title), '[BLANK]');
        $optionsCount = count($this->blanks);
        if ($blankCount !== $optionsCount) {
            $this->addError('question_title', __('quiz::quiz.blank_count_mismatch'));
            return;
        }

        $options = array_map(function ($key, $mcq) {
            return [
                'option_text'   => $mcq['option_text'],
                'is_correct'    => 1,
            ];
        }, array_keys($this->blanks), $this->blanks);


        return [
            'title'             => $this->question_title,
            'description'        => $this->question_text,
            'options'            => $options
        ];
    }

    public function setQuestion($question)
    {
        $this->question_title       = $question['title'] ?? '';
        $options = (new QuestionService)->getQuestionOptions($question['id']);

        $this->blanks = array_map(function ($option, $key) {
            return [
                'option_text' => $option['option_text'],
            ];
        }, $options ? $options->toArray() : [], array_keys($options ? $options->toArray() : []));
    }

    public function addFillInBlanksOption()
    {
        $this->blanks[] = ['option_text' => ''];
    }

    public function removeFillInBlanksOption($index)
    {
        unset($this->blanks[$index]);
        $this->blanks = array_values($this->blanks);
    }
}
