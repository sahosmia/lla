<?php


namespace Modules\Quiz\Livewire\Pages\Tutor\QuizCreation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Quiz\Livewire\Forms\QuizSettingForm;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Services\QuizService;


class QuizSettings extends Component
{
    public QuizSettingForm $form;

    public $quizId;
    public $quiz;
    public $tab = 'settings';
    public $user;
    public $questionType;
    protected $quizService;
    public $routeName;
    public $quizStatus;

    public function boot()
    {
        $this->quizService  = new QuizService();
    }

    public function mount($quizId = null)
    {
        $this->routeName = Route::currentRouteName();
        $this->quizId = $quizId;
        if ($this->quizId) {
            $this->quiz = $this->quizService->getQuizSettings($this->quizId);

            if (empty(!$this->quiz)) {
                $this->form->setQuizDetail($this->quiz);
            } else {
                abort(404);
            }
        }

        $this->quizStatus = $this->quizService->getQuizStatus($this->quizId);

        if (empty($this->quiz) || $this->quizStatus == Quiz::STATUS_ARCHIVED) {
            abort(404);
        }

        $this->user = Auth::user();
        $this->questionType = $this->quizService->getQuizQuestionType($this->quizId);
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    public function updatedForm($value, $key)
    {
        if ($key == 'hide_Quiz') {

            $this->form->hide_Quiz = $value;
        } elseif ($key == 'hide_question') {

            $this->form->hide_question = $value;
        } elseif ($key == 'auto_result_generate') {

            if (!empty(array_intersect($this->questionType, ['open_ended_essay', 'short_answer']))) {
                $this->form->auto_result_generate = false;
                $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.generate_warning'), message: __('quiz::quiz.auto_generate_warning'));
            }
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('quiz::livewire.tutor.quiz-creation.quiz-setting', [
            'id' => $this->quizId,
        ]);
    }


    public function saveQuizSetting()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if ($this->quizStatus == Quiz::STATUS_PUBLISHED) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.not_allowd'), message: __('quiz::quiz.not_perform_action'));
            return;
        }

        $quizSetting = $this->form->validateSettingDetail();
        if (!empty($quizSetting)) {
            $quizSetting = $this->quizService->addQuizSettings($this->quizId, $quizSetting);
            $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.quiz_created'), message: __('quiz::quiz.quiz_settings_updated_successfully'));
        }
    }
}
