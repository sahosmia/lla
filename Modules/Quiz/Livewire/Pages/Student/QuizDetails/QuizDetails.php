<?php

namespace Modules\Quiz\Livewire\Pages\Student\QuizDetails;

use App\Models\Rating;
use App\Models\User;
use App\Services\SiteService;
use App\Services\UserService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Services\QuizService;

class QuizDetails extends Component
{
    public int $attemptId;
    public Quiz|null $quiz;

    public User $user;
    public $tutor;
    public $totalSlots;
    public $quizAttempt;
    public $reviews;
    public $isFavourite;
    public $fullDescription = false;

    protected QuizService $quizService;
    protected SiteService $siteService;

    public function boot(QuizService $quizService, SiteService $siteService)
    {
        $this->quizService  = $quizService;
        $this->siteService  = $siteService;
    }
    /**
     * Mount the component with the provided quiz ID.
     *
     * @param int $quizId
     * @return void
     */

    public function mount($attemptId)
    {
        $this->attemptId = $attemptId;
        $this->user = Auth::user();

        $this->quizAttempt = $this->quizService->getAttemptedQuiz(
            select: ['id', 'quiz_id', 'student_id', 'started_at', 'completed_at', 'active_question_id', 'total_marks', 'total_questions', 'result', 'created_at', 'updated_at'],
            relations: [
                'quiz' => function ($q) {
                    $q->where('status', Quiz::PUBLISHED);
                },
                'quiz.quizzable',
                'quiz.questions:id,quiz_id,title,type,description,points,settings',
                'quiz.questions.options:id,question_id,option_text,is_correct',
                'quiz.questions.options.image:mediable_id,mediable_type,type,path',
                'quiz.questions.thumbnail:mediable_id,mediable_type,type,path',
                'quiz.tutor.profile:id,user_id,slug,first_name,last_name,image',
                'quiz.settings:quiz_id,meta_key,meta_value,created_at,updated_at',
            ],
            attemptId: $this->attemptId,
            withSum: [
                ['quiz' => fn($q) => $q->withSum('points'), 'total_points', 'points'],
            ],
            studentId: $this->user->id,
        );

        if (!$this->quizAttempt) {
            abort(404);
        }

        if (!empty($this->quizAttempt) && !empty($this->quizAttempt->started_at) && !empty($this->quizAttempt->active_question_id)) {

            return redirect()->route('quiz.student.attempt-quiz', ['attemptId' => $this->quizAttempt->id]);
        }

        $this->tutor = $this->siteService->getTutorDetail($this->quizAttempt?->quiz?->tutor?->profile?->slug);
    }

    #[Layout('quiz::layouts.quiz')]
    public function render()
    {
        $completedAt = null;
        $totalGrade = null;

        if (!empty($latestAttempt)) {
            $completedAt    = $latestAttempt->completed_at ? Carbon::parse($latestAttempt?->completed_at)->format(setting('_general.date_format') ?? "F j Y") : null;
            $totalGrade     = $latestAttempt->total_marks > 0 ? round(($latestAttempt->earned_marks / $latestAttempt->total_marks) * 100, 2) : 0;
        }

        $passingGrade       = $this->quizAttempt?->quiz?->settings?->where('meta_key', 'passing_grade')->first()?->meta_value ?? 0;


        $this->totalSlots = $this->tutor?->subjects?->flatMap(function ($subject) {
            return $subject->slots;
        })->count();

        $userService = new UserService($this->user);
        $this->isFavourite = $userService->isFavouriteUser($this->tutor?->id ?? 0);
        if ($this->tutor?->profile?->verified_at) {
            $this->reviews       = Rating::where('tutor_id', $this->tutor?->id ?? 0)->count();
        }

        return view('quiz::livewire.student.quiz-details.quiz-details', [
            'passingGrade'      => $passingGrade,
            'completedAt'       => $completedAt,
            'totalGrade'        => $totalGrade
        ]);
    }

    public function toggleDescription()
    {
        $this->fullDescription = !$this->fullDescription;
    }

    public function startQuiz()
    {
        $this->quizService->startQuiz($this->quizAttempt->id);
        return redirect()->route('quiz.student.attempt-quiz', ['attemptId' => $this->quizAttempt->id]);
    }
}
