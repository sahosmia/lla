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
<<<<<<< HEAD
        $completedAt = null;
        $totalGrade = null;

        if (!empty($latestAttempt)) {
            $completedAt    = $latestAttempt->completed_at ? Carbon::parse($latestAttempt?->completed_at)->format(setting('_general.date_format') ?? "F j Y") : null;
            $totalGrade     = $latestAttempt->total_marks > 0 ? round(($latestAttempt->earned_marks / $latestAttempt->total_marks) * 100, 2) : 0;
        }

        $passingGrade       = $this->quizAttempt?->quiz?->settings?->where('meta_key', 'passing_grade')->first()?->meta_value ?? 0;

=======
        $allAttempts = \Modules\Quiz\Models\QuizAttempt::where('quiz_id', $this->quizAttempt->quiz_id)
            ->where('student_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $completedAttempts = $allAttempts->where('result', '!=', \Modules\Quiz\Models\QuizAttempt::RESULT_ASSIGNED);

        $bestAttempt = $completedAttempts->sortByDesc('earned_marks')->first();
        $latestAttempt = $allAttempts->first();

        $attemptsAllowedSetting = $this->quizAttempt->quiz->settings->where('meta_key', 'attempts_allowed')->first();
        $attemptsAllowedValue = $attemptsAllowedSetting ? $attemptsAllowedSetting->meta_value : 1;
        $attemptsAllowed = is_array($attemptsAllowedValue) ? ($attemptsAllowedValue[0] ?? 1) : $attemptsAllowedValue;

        $attemptsMade = $allAttempts->count();
        $remainingAttempts = $attemptsAllowed - $attemptsMade;

        $completedAt = null;
        $totalGrade = null;
        $hasPassed = false;

        if (!empty($bestAttempt)) {
            $completedAt = $bestAttempt->completed_at ? Carbon::parse($bestAttempt->completed_at)->format(setting('_general.date_format') ?? "F j Y") : null;
            $totalGrade = $bestAttempt->total_marks > 0 ? round(($bestAttempt->earned_marks / $bestAttempt->total_marks) * 100, 2) : 0;
            if ($bestAttempt->result == 'pass') {
                $hasPassed = true;
            }
        }

        $passingGradeValue = $this->quizAttempt?->quiz?->settings?->where('meta_key', 'passing_grade')->first()?->meta_value ?? 0;
        $passingGrade = is_array($passingGradeValue) ? ($passingGradeValue[0] ?? 0) : $passingGradeValue;
>>>>>>> master

        $this->totalSlots = $this->tutor?->subjects?->flatMap(function ($subject) {
            return $subject->slots;
        })->count();

        $userService = new UserService($this->user);
        $this->isFavourite = $userService->isFavouriteUser($this->tutor?->id ?? 0);
        if ($this->tutor?->profile?->verified_at) {
<<<<<<< HEAD
            $this->reviews       = Rating::where('tutor_id', $this->tutor?->id ?? 0)->count();
=======
            $this->reviews = Rating::where('tutor_id', $this->tutor?->id ?? 0)->count();
>>>>>>> master
        }

        return view('quiz::livewire.student.quiz-details.quiz-details', [
            'passingGrade'      => $passingGrade,
            'completedAt'       => $completedAt,
<<<<<<< HEAD
            'totalGrade'        => $totalGrade
=======
            'totalGrade'        => $totalGrade,
            'bestAttempt'       => $bestAttempt,
            'latestAttempt'     => $latestAttempt,
            'remainingAttempts' => $remainingAttempts,
            'attemptsMade'      => $attemptsMade,
            'attemptsAllowed'   => $attemptsAllowed,
            'hasPassed'         => $hasPassed,
>>>>>>> master
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
<<<<<<< HEAD
=======

    public function retakeQuiz()
    {
        $completedAttempts = \Modules\Quiz\Models\QuizAttempt::where('quiz_id', $this->quizAttempt->quiz_id)
            ->where('student_id', $this->user->id)
            ->where('result', '!=', \Modules\Quiz\Models\QuizAttempt::RESULT_ASSIGNED)
            ->get();

        $bestAttempt = $completedAttempts->sortByDesc('earned_marks')->first();

        if ($bestAttempt && $bestAttempt->result == \Modules\Quiz\Models\QuizAttempt::RESULT_PASSED) {
            // If student has already passed, don't allow retake.
            // The button should be hidden in the view, but this is a server-side check.
            return;
        }

        $newAttempt = $this->quizService->assignQuiz($this->quizAttempt->quiz_id, [$this->user->id]);

        if ($newAttempt) {
            return redirect()->route('quiz.student.quiz-details', ['attemptId' => $newAttempt->id]);
        }
    }
>>>>>>> master
}
