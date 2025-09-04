<?php

namespace Modules\Quiz\Livewire\Forms;

use Modules\Quiz\Http\Requests\QuizRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\PrepareForValidation;
use Livewire\WithFileUploads;
use Livewire\Form;
use Modules\Quiz\Models\Question;

class CreateFormQuiz extends Form
{
    use WithFileUploads;
    use PrepareForValidation;

    public $quizzable_type  = '';
    public $quizzable_id    = '';
    public $title           = '';
    public $description     = '';
    public $user_subject_slots = [];
    public $question_types = [];
    public $status = 'draft';
    
    private ?QuizRequest $request = null;

    public function boot() {
        $this->request = new QuizRequest();
    }

    public function rules(){
        $this->request->quizzable_type = $this->quizzable_type;
        $this->sanitizeFields();
        return $this->request->rules();
    }

    protected function sanitizeFields()
    {
        $this->title        = sanitizeTextField($this->title);
        $this->description  = sanitizeTextField($this->description, keep_linebreak: true);
    }

    public function messages(){
        return $this->request->messages();
    }

    public function setQuestionTypes(){
        $this->question_types = [
            Question::TYPE_TRUE_FALSE       => setting('_quiz.max_number_of_'.Question::TYPE_TRUE_FALSE.'_questions_by_ai') ?? 0,
            Question::TYPE_MCQ              => setting('_quiz.max_number_of_'.Question::TYPE_MCQ.'_questions_by_ai') ?? 0,
            Question::TYPE_OPEN_ENDED_ESSAY => setting('_quiz.max_number_of_'.Question::TYPE_OPEN_ENDED_ESSAY.'_questions_by_ai') ?? 0,
            Question::TYPE_FILL_IN_BLANKS   => setting('_quiz.max_number_of_'.Question::TYPE_FILL_IN_BLANKS.'_questions_by_ai') ?? 0,
            Question::TYPE_SHORT_ANSWER     => setting('_quiz.max_number_of_'.Question::TYPE_SHORT_ANSWER.'_questions_by_ai') ?? 0,
        ];
    }


    public function setQuizDetail($quiz = []){
        $this->quizzable_type      = $quiz['quizzable_type'] ?? '';
        $this->quizzable_id        = $quiz['quizzable_id'] ?? '';
        $this->title               = $quiz['title'] ?? '';
        $this->description         = $quiz['description'] ?? '';
        $this->user_subject_slots  = !empty($quiz['user_subject_slots']) ? array_values($quiz['user_subject_slots']) : [];
        $this->status         = $quiz['status'] ?? 'draft';
    }

    public function validateQuizDetail(){
        $this->validate($this->rules());

        $data = [
            'quizzable_type'               => $this->quizzable_type,
            'quizzable_id'                 => $this->quizzable_id,
            'title'                        => $this->title,
            'description'                  => $this->description,
            'user_subject_slots'           => !empty($this->user_subject_slots) ? $this->user_subject_slots : null,
            'status'                       => $this->status
        ];
        
        return $data;
    }

    public function validateAi(){
        $rules = $this->rules();
        unset($rules['title']);
        $rules['description']                       = 'required|string';
        $rules['question_types']                    = 'required|array|min:1';
        $message = $this->messages();
        foreach($this->question_types as $key => $value){
            $rules['question_types.'.$key]         = 'nullable|integer|between:0,'.setting('_quiz.max_number_of_'.$key.'_questions_by_ai') ?? 0;
            $message['question_types.*.between']   = __('quiz::quiz.question_types_out_of_range', ['max' => setting('_quiz.max_number_of_'.$key.'_questions_by_ai') ?? 0]);
        }
        $message['question_types.required']         = __('quiz::quiz.question_types_required');
        $message['question_types.array']            = __('quiz::quiz.question_types_required');
        $message['question_types.min']              = __('quiz::quiz.question_types_required');
        $message['question_types.*.integer']        = __('quiz::quiz.question_types_integer');
        $this->validate($rules, $message);
    }
}
