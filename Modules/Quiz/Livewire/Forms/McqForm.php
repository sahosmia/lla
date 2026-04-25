<?php

namespace Modules\Quiz\Livewire\Forms;

use App\Traits\PrepareForValidation;
use Livewire\WithFileUploads;
use Livewire\Form;
use Modules\Quiz\Http\Requests\QuestionTypes\McqRequest;
use Modules\Quiz\Services\QuestionService;

class McqForm extends Form
{
    use WithFileUploads;
    use PrepareForValidation;

    public $type  = '';
    public $question_title          = '';
    public $question_text           = '';
    public $correct_answer          = null;
    public $mcqs  = [['option_text' => '', 'position' => 1]];

    private ?McqRequest $request = null;

    public function boot()
    {
        $this->request = new McqRequest();
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

        $this->validate($this->request->rules(), $this->request->messages(), $this->request->attributes());
        $options = array_map(function ($key, $mcq) {
            return [
                'option_text'   => $mcq['option_text'],
                'position'      => $mcq['position'] ?? $key,
                'is_correct'    => $key == $this->correct_answer,
            ];
        }, array_keys($this->mcqs), $this->mcqs);

        return [
            'title'             => $this->question_title,
            'description'        => $this->question_text,
            'options'            => $options
        ];
    }

    public function setQuestion($question)
    {
        $this->question_title       = $question['title'] ?? '';
        $this->question_text        = $question['description'] ?? '';
        $options = (new QuestionService)->getQuestionOptions($question['id']);


        $this->mcqs = array_map(function ($option, $key) {
            if (!empty($option['is_correct'])) {
                $this->correct_answer = $key;
            }
            return [
                'option_text' => $option['option_text'],
                'position' => $option['position'] ?? $key,
            ];
        }, $options ? $options->toArray() : [], array_keys($options ? $options->toArray() : []));
    }

    public function removeMcq($index)
    {
        unset($this->mcqs[$index]);
        $this->mcqs = array_values($this->mcqs);

        foreach ($this->mcqs as $key => &$mcq) {
            if ($mcq['position'] > $index) {
                $mcq['position'] = $mcq['position'] - 1;
            }
        }
        if ($index == $this->correct_answer) {
            $this->correct_answer = null;
        }
    }

    public function addMcqOption()
    {
        $this->mcqs[] = [
            'option_text' => '',
            'position' => count($this->mcqs) + 1,
        ];
        $this->correct_answer = null;
    }
}
