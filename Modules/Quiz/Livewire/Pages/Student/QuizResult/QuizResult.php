<?php

namespace Modules\Quiz\Livewire\Pages\Student\QuizResult;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Quiz\Models\QuizAttempt;
use Modules\Quiz\Services\QuestionService;
use Modules\Quiz\Services\QuizService;

class QuizResult extends Component
{
    protected $questionService, $quizService;
    public $user;
    public $quizId;

    public $course;

    public $attemptId;
    public $quizAttempt;

    public $dateFormat;
    public $timeFormat;
    public $userId;

    public function boot()
    {
        $this->user             = Auth::user();
        $this->questionService  = new QuestionService();
        $this->quizService      = new QuizService();
    }

    public function mount(int $attemptId = null)
    {
        $this->attemptId        = $attemptId;
        $this->dateFormat       = setting('_general.date_format') ?? "F j Y";
        $this->timeFormat       = setting('_lernen.time_format') ?? "h:i a";

        $attemptQuiz = $this->getQuizResult;
        $role = $this->user->role;
        
        if( $role == 'student' && $attemptQuiz?->student_id != $this->user->id){
            abort(404);
        }
        
        if( $role == 'tutor' && $attemptQuiz?->quiz?->tutor_id != $this->user->id ){
            abort(404);
        }
    }


    #[Computed]
    public function getQuizResult()
    {
        return $this->quizService->getStudentAttemptedQuiz(
            attemptId: $this->attemptId,
            statuses: [QuizAttempt::IN_REVIEW, QuizAttempt::PASS, QuizAttempt::FAIL],
            role: $this->user->role,
            userId: $this->user->id,
        );
    }

    #[Layout('quiz::layouts.quiz')]
    public function render()
    {
        $attemptQuiz = $this->getQuizResult;

        if (empty($attemptQuiz)) {
            abort(404);
        }
        // $duration      = $attemptQuiz?->quiz?->settings?->where('meta_key', 'duration')->first()?->meta_value ?? 0;
        // $passingGrade  = $attemptQuiz?->quiz?->settings?->where('meta_key', 'passing_grade')->first()?->meta_value ?? 0;
        // $completedAt   = $attemptQuiz?->completed_at ? Carbon::parse($attemptQuiz?->completed_at)->format($this->dateFormat) : null;

        return view('quiz::livewire.student.quiz-result.quiz-result', compact('attemptQuiz'));
    }
}
