<?php

namespace Modules\Quiz\Livewire\Forms;

use App\Traits\PrepareForValidation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Livewire\WithFileUploads;
use Modules\Quiz\Http\Requests\QuizSettingRequest;

class QuizSettingForm extends Form
{
    use WithFileUploads;
    use PrepareForValidation;

    public $hours            = '';
    public $minutes       = '';
    public $hide_Quiz           = false;
    public $attempts_allowed    = '';
    public $passing_grade       = '';
    public $question_order      = '';    
    public $hide_question       = false;
    public $limit_short_answers = '';
    public $limit_max_answers = '';
    public $auto_result_generate = false;

    private ?QuizSettingRequest $request = null;

    public function boot() {
        $this->request = new QuizSettingRequest();
    }


    public function rules(){
        return $this->request->rules();
    }

    public function messages(){
        return $this->request->messages();
    }


    public function setQuizDetail($quiz = []){
        
        if (!empty($quiz['duration'])) {
            [$hours, $minutes] = explode(':', $quiz['duration']);
            $this->hours = $hours; 
            $this->minutes = $minutes; 
        } else {
            $this->hours = '';
            $this->minutes = '';
        }
        $this->hide_Quiz           = $quiz['hide_quiz_timer'] == 1 ? true : false;
        $this->attempts_allowed    = $quiz['attempts_allowed'] ?? '';
        $this->passing_grade       = $quiz['passing_grade'] ?? '';
        $this->question_order      = $quiz['question_order'] ?? '';
        $this->hide_question       = $quiz['hide_question_number'] == 1 ? true : false;
        $this->limit_short_answers = $quiz['short_ans_limit'] ?? '';
        $this->limit_max_answers   = $quiz['max_ans_limit'] ?? '';
        $this->auto_result_generate = $quiz['auto_result_generate'] == 1 ? true : false;

    }

    protected function passedValidation()
    {
        $hours = intval($this->hours);
        $minutes = intval($this->minutes);

        if ( empty($hours) && $minutes < 5 ) {
            $this->addError('minutes', 'Please add atleast 5 minutes');
            return false;
        }
        return true;
    }
    
    public function validateSettingDetail(){

        $this->validate($this->rules());
        if (!$this->passedValidation()) {
            return false;
        }
        $duration = $this->hours .':'. $this->minutes;

        $data = [
            'duration'                  => $duration,
            'hide_quiz_timer'           => $this->hide_Quiz ? 1 : 0,
            'attempts_allowed'          => $this->attempts_allowed,
            'passing_grade'             => $this->passing_grade,
            'question_order'            => $this->question_order,
            'hide_question_number'      => $this->hide_question ? 1 : 0,
            'short_ans_limit'           => $this->limit_short_answers,
            'max_ans_limit'             => $this->limit_max_answers,
            'auto_result_generate'      => $this->auto_result_generate ? 1 : 0,
        ];
        
        return $data;
    }
}
