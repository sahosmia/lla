<?php


namespace Modules\Quiz\Livewire\Pages\Tutor\QuizCreation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use Modules\Quiz\Livewire\Forms\QuizSettingForm;
use Modules\Quiz\Models\Question;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Services\QuestionService;
use Modules\Quiz\Services\QuizService;


class QuestionManager extends Component
{
    public QuizSettingForm $form;

    public $quizId;
    public $quizStatus;
    public $questionType;
    public $isLoading = true;
    public $keyword;
    protected $quizService;
    public $questions;
    public $perPage;
    protected $questionService;
    public $routeName;

    public function boot()
    {
        $this->quizService  = new QuizService();
        $this->questionService  = new QuestionService();
    }

    public function mount($quizId = null)
    {
        $this->routeName = Route::currentRouteName();
        $this->quizId = $quizId;
        $this->perPage        = setting('_general.per_page_record') ?? 10;
        if (empty($this->quizId) || !is_numeric($this->quizId)) {
            abort(404);
        }

        $quiz = $this->quiz;

        $this->quizStatus = $this->quiz->status;

        if (empty($quiz) || $quiz?->status == Quiz::STATUS_ARCHIVED) {
            abort(404);
        }

        $this->dispatch('initSelect2', target: '.am-select2');
    }

    #[Computed(persist: false)]
    public function quiz()
    {
        return $this->quizService->getQuiz(
            select: ['id', 'tutor_id', 'quizzable_type', 'quizzable_id', 'title', 'description', 'status'],
            withCount: ['questions'],
            quizId: $this->quizId,
            tutorId: Auth::id(),
        );
    }


    #[Layout('layouts.app')]
    public function render()
    {
        $this->questions = $this->questionService->getAllQuestions($this->quizId, $this->questionType, $this->keyword);

        $autoResultGenerte = $this->quiz?->settings?->where('meta_key', 'auto_result_generate')?->first()?->meta_value[0] ?? false;

        $questionTypes = [
            ['type' => Question::TYPE_TRUE_FALSE, 'value' => Question::TRUE_FALSE, 'is_disabled' => false],
            ['type' => Question::TYPE_MCQ, 'value' => Question::MCQ, 'is_disabled' => false],
            ['type' => Question::TYPE_FILL_IN_BLANKS, 'value' => Question::FILL_IN_BLANKS, 'is_disabled' => false],
            ['type' => Question::TYPE_OPEN_ENDED_ESSAY, 'value' => Question::OPEN_ENDED_ESSAY, 'is_disabled' => $autoResultGenerte],
            ['type' => Question::TYPE_SHORT_ANSWER, 'value' => Question::SHORT_ANSWER, 'is_disabled' => $autoResultGenerte],
        ];
        $quiz = $this->quiz;
        return view('quiz::livewire.tutor.quiz-creation.question-manager', compact('questionTypes', 'autoResultGenerte', 'quiz',));
    }

    public function loadData()
    {
        $this->isLoading = false;
    }


    #[On('delete-question')]
    public function deleteQuestion($params)
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $this->questionService->deleteQuestion($params['id']);
        $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.delete_question'), message: __('quiz::quiz.question_delete_successfully'));
    }

    public function publishQuiz()
    {

        $response = isDemoSite();

        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id: 'course_completed_popup', action: 'hide');
            return;
        }

        if (empty($this->questions)) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.quiz_publish'), message: __('quiz::quiz.quiz_publish_failed'));
            return;
        }

        $publishedQuiz = $this->quizService->publishQuiz($this->quizId);
        
        $quiz = Quiz::where('id', $this->quizId)->first();

        if ($quiz && $quiz?->quizzable_type == 'Modules\Courses\Models\Course' && isActiveModule('courses')) {
            $quiz->load('quizzable.enrollments');

            $courseDuration = (new \Modules\Courses\Services\CourseService())->getCourseProgress(
                courseId: $quiz?->quizzable_id,
                withSum: [
                    'courseWatchedtime' => 'duration'
                ],
                studentId: $quiz?->quizzable?->enrollments->pluck('student_id')->toArray()
            );
            if (!empty($courseDuration?->course_watchedtime_sum_duration) && !empty($quiz?->quizzable?->content_length)) {
                foreach ($quiz?->quizzable?->enrollments as $enrollment) {
                    $this->progress = floor(($courseDuration?->course_watchedtime_sum_duration / $quiz?->quizzable?->content_length) * 100);
                    if ($this->progress >= 100) {
                        (new \Modules\Quiz\Services\QuizService())->autoAssignQuiz($quiz?->quizzable, $enrollment?->student_id);
                    }
                }
            }
        } else {
            if (isActiveModule('quiz')) {
                $bookings = \App\Models\SlotBooking::get();
                foreach ($bookings as $booking) {
                    $sessionEndDate = $booking->end_time;
                    if ($sessionEndDate && $sessionEndDate < now()) {
                        $quiz = (new \Modules\Quiz\Services\QuizService())->quizzsBySlot($booking->user_subject_slot_id);
                        if ($quiz->isNotEmpty()) {
                            foreach ($quiz as $quiz) {
                                if ($quiz->status == 'published') {
                                    $quizDetail = (new \Modules\Quiz\Services\QuizService())->assignQuiz($quiz->id, [$booking->student_id]);

                                    if ($quizDetail && isset($quizDetail->id)) {
                                        $emailData = [
                                            'quizTitle'       => $quiz->title,
                                            'studentName'     => $booking->student?->full_name,
                                            'tutorName'       => $quiz->tutor?->profile?->full_name,
                                            'assignedQuizUrl' => route('quiz.student.quizzes'),
                                        ];
                                    
                                        $notifyData = $emailData;
                                    
                                        dispatch(new \App\Jobs\SendNotificationJob('assignedQuiz', $booking->booker, $emailData));
                                        dispatch(new \App\Jobs\SendDbNotificationJob('assignedquiz', $booking->booker, $notifyData));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($publishedQuiz)) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.quiz_publish'), message: __('quiz::quiz.quiz_publish_successfully'));
            return redirect()->route('quiz.tutor.quizzes');
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.quiz_publish'), message: __('quiz::quiz.quiz_publish_failed'));
        }
    }

    public function updateQuistionPosition($list)
    {
        $response = isDemoSite();

        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if (!empty($list)) {
            $response = $this->questionService->udpateQuestionPosition($this->quizId, $list);
        }
    }
}
