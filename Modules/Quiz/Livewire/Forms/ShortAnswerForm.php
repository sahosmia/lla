<?php

namespace Modules\Quiz\Livewire\Forms;

use App\Traits\PrepareForValidation;
use Livewire\WithFileUploads;
use Livewire\Form;
use Modules\Quiz\Http\Requests\QuestionTypes\ShortAnswerRequest;
use Modules\Quiz\Models\Question;
use Modules\Quiz\Services\QuestionService;

class ShortAnswerForm extends Form
{
    use WithFileUploads;
    use PrepareForValidation;

    public $type  = '';
    public $question_title          = '';
    public $question_text           = '';
    public $question_id             = null;

    private ?ShortAnswerRequest $request = null;

    public function boot()
    {
        $this->request = new ShortAnswerRequest();
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
            'title'                 => $this->question_title,
            'description'         => $this->question_text,
        ];
    }

    public function setQuestion($question)
    {

        $this->question_id          = $question['id'] ?? null;
        $this->question_title       = $question['title'] ?? '';
        $this->question_text        = $question['description'] ?? '';
    }
}
