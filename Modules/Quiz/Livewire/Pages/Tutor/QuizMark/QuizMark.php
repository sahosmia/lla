<?php

namespace Modules\Quiz\Livewire\Pages\Tutor\QuizMark;

use App\Jobs\GenerateCertificateJob;
use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendNotificationJob;
use App\Jobs\SendDbNotificationJob;
use App\Models\UserSubjectGroupSubject;
use App\Models\UserSubjectSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Quiz\Http\Requests\MarkQuizRequest;
use Modules\Quiz\Models\Question;
use Modules\Quiz\Models\QuizAttempt;
use Modules\Quiz\Services\QuestionService;
use Modules\Quiz\Services\QuizService;
use Modules\Upcertify\Models\Certificate;


class QuizMark extends Component
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
    public $requiredAnswers = [];

    public function boot()
    {
        $this->user             = Auth::user();
        $this->questionService  = new QuestionService();
        $this->quizService      = new QuizService();
        $this->markQuizRequest  = new MarkQuizRequest();
    }

    public function mount(int $attemptId = null)
    {
        $this->attemptId        = $attemptId;
        $this->dateFormat       = setting('_general.date_format') ?? "F j Y";
        $this->timeFormat       = setting('_lernen.time_format') ?? "h:i a";

        $attemptQuiz = $this->getQuizResult();

        if ($attemptQuiz->result != QuizAttempt::RESULT_IN_REVIEW) {
            abort(404);
        }

        if ($attemptQuiz->quiz->tutor_id != $this->user->id) {
            abort(404);
        }

        $questionTypes = [Question::TYPE_OPEN_ENDED_ESSAY, Question::TYPE_SHORT_ANSWER];

        if (!empty($attemptQuiz)) {
            $answers = [];

            foreach ($attemptQuiz->quiz?->questions as $question) {
                if (in_array($question?->type, $questionTypes)) {
                    $answers[] = [
                        'question_id' => $question?->id,
                        'marks_awarded' => '',
                        'maximum_marks' => $question?->points
                    ];
                }
            }
            if (!empty($answers)) {
                $this->requiredAnswers = $answers;
            }
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
        $attemptQuiz = $this->getQuizResult();

        if (empty($attemptQuiz)) {
            abort(404);
        }

        $completedDuration = Carbon::parse($attemptQuiz->started_at)->diffInSeconds(Carbon::parse($attemptQuiz->completed_at));

        return view('quiz::livewire.tutor.quiz-mark.quiz-mark', compact('attemptQuiz', 'completedDuration'));
    }

    public function submitResult()
    {
        $this->validate($this->markQuizRequest->rules(), $this->markQuizRequest->messages());

        try {
            DB::beginTransaction();

            // Save question attempts
            foreach ($this->requiredAnswers as $answer) {
                $data = [
                    'quiz_attempt_id'       => $this->attemptId,
                    'question_id'           => $answer['question_id'],
                    'is_correct'            => $answer['marks_awarded'] > 0 ? 1 : 0,
                    'marks_awarded'         => $answer['marks_awarded'] ?? 0,
                ];
                $this->questionService->createQuestionAttempt($data);
            }

            $this->quizAttempt = $this->quizService->getQuizAttempt(
                $this->attemptId,
                [
                    'attemptedQuestions',
                    'quiz.tutor.profile',
                    'quiz.tutor.profile',
                    'student.profile'
                ]
            );
            $quizAttempt = $this->getQuizResult;

            if (empty($quizAttempt)) {
                abort(404);
            }

            // Calculate quiz results
            $passingGrade = $quizAttempt->quiz->settings?->where('meta_key', 'passing_grade')->first()?->meta_value ?? 0;
            $correctAnswers = $quizAttempt->attemptedQuestions->where('is_correct', true)->count();
            $inCorrectAnswers = $quizAttempt->attemptedQuestions->where('is_correct', false)->count();
            $earnedMarks = $quizAttempt->attemptedQuestions->sum('marks_awarded');

            $quizAttemptData = [
                'correct_answers'   => $correctAnswers,
                'incorrect_answers' => $inCorrectAnswers,
                'earned_marks'      => $earnedMarks,
                'completed_at'      => now(),
            ];

            $quizAttempt->update($quizAttemptData);

            $percentageMarks = $earnedMarks / $quizAttempt->total_marks * 100;
            $percentageMarks = round($percentageMarks, 2);

            $quizAttempt->result = $percentageMarks >= $passingGrade ? 'pass' : 'fail';
            $quizAttempt->save();

            $student = User::with('profile')->find($quizAttempt?->student_id);

            $emailData = [
                'quizTitle'       => $quizAttempt?->quiz?->title,
                'studentName'     => $student?->profile?->full_name,
                'tutorName'       => $quizAttempt?->quiz?->tutor?->profile?->full_name,
                'quizUrl'         => route('quiz.quiz-result', ['attemptId' => $quizAttempt->id])
            ];

            $notifyData = [
                'quizTitle'       => $quizAttempt?->quiz?->title,
                'studentName'     => $student?->profile?->full_name,
                'tutorName'       => $quizAttempt?->quiz?->tutor?->profile?->full_name,
                'quizResultUrl'   => route('quiz.quiz-result', ['attemptId' => $quizAttempt->id])
            ];

            dispatch(new SendNotificationJob('generateQuizResult', $student, $emailData));
            dispatch(new SendDbNotificationJob('generateQuizResult', $student, $notifyData));

            $this->assignCertificate();

            DB::commit();

            $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.quiz_submit'), message: __('quiz::quiz.queiz_submitted_desc'));
            sleep(1);
            $this->redirect(route('quiz.quiz-result', ['attemptId' => $this->attemptId]));
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.quiz_submit'), message: __('quiz::quiz.error_submitting_quiz'));
            throw $ex;
        }
    }

    private function assignCertificate()
    {
        if (isActiveModule('Upcertify') && $this->quizAttempt?->result == 'pass') {
            $allQuizAttempts = QuizAttempt::where('student_id', $this->quizAttempt?->student_id)
                ->whereHas('quiz', function ($query) {
                    $query->where('quizzable_id', $this->quizAttempt?->quiz?->quizzable_id)
                        ->where('quizzable_type', $this->quizAttempt?->quiz?->quizzable_type);
                })
                ->where('result', '<>', QuizAttempt::PASS)
                ->exists();

            if (isActiveModule('Courses') && $this->quizAttempt?->quiz?->quizzable_type == \Modules\Courses\Models\Course::class) {

                $this->course = $this->quizAttempt?->quiz?->quizzable;
                $this->course->load('instructor.profile');

                $metaData = $this->course?->meta_data['assign_quiz_certificate'] ?? null;

                if (!empty($metaData)) {
                    if ($metaData == 'any') {
                        $this->generateCertificate();
                    }

                    if ($metaData == 'all') {
                        if (!$allQuizAttempts) {
                            $this->generateCertificate();
                        }
                    }
                }
            } elseif ($this->quizAttempt->quiz?->quizzable_type == UserSubjectGroupSubject::class) {
                $slots = UserSubjectSlot::whereIn('id', $this->quizAttempt->quiz?->user_subject_slots)->get();

                if ($slots->isNotEmpty()) {
                    foreach ($slots as $slot) {
                        if (!empty($slot->metadata['template_id'])) {
                            if ($slot->metadata['assign_quiz_certificate'] == 'any') {
                                $booking = $slot->bookings->whereStudentId($this->quizAttempt->student_id)->first();
                                if ($booking) {
                                    dispatch(new GenerateCertificateJob($booking));
                                }
                            }
                            if ($slot->metadata['assign_quiz_certificate'] == 'all') {
                                if (!$allQuizAttempts) {
                                    $booking = $slot->bookings->whereStudentId($this->quizAttempt->student_id)->first();
                                    if ($booking) {
                                        dispatch(new GenerateCertificateJob($booking));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function generateCertificate()
    {
        $wildcard_data = [
            'tutor_name'         => $this->course?->instructor?->profile?->full_name ?? '',
            'student_name'       => $this->quizAttempt?->student?->profile?->full_name ?? '',
            'gender'             => !empty($this->quizAttempt?->student?->profile?->gender) ? ucfirst($this->quizAttempt?->student?->profile?->gender) : '',
            'tutor_tagline'      => $this->course?->instructor?->profile?->tagline ?? '',
            'issued_by'          => $this->course?->instructor?->profile?->full_name ?? '',
            'platform_name'      => setting('_general.site_name'),
            'platform_email'     => setting('_general.site_email'),
            'course_title'       => $this->course?->title ?? '',
            'course_subtitle'    => $this->course?->subtitle ?? '',
            'course_description' => $this->course?->description ?? '',
            'course_category'    => $this->course?->category?->name ?? '',
            'course_subcategory' => $this->course?->subCategory?->name ?? '',
            'course_type'        => $this->course?->type ?? '',
            'course_level'       => $this->course?->level ?? '',
            'course_language'    => $this->course?->language?->name ?? '',
            'free_course'        => $this->course?->is_free ? 'Yes' : 'No',
            'course_price'       => $this->course?->pricing?->price ? formatAmount($this->course?->pricing?->price) : '',
            'course_discount'    => $this->course?->pricing?->discount ? formatAmount($this->course?->pricing?->discount) : '',
            'issue_date'         => now()->format(setting('_general.date_format')),
            'student_email'      => $this->quizAttempt?->student?->email ?? '',
            'tutor_email'        => $this->course?->instructor?->email ?? '',
        ];

        if (Certificate::where('template_id', $this->course?->certificate_id)->where('modelable_type', User::class)->where('modelable_id', auth()->user()->id)->exists()) {
            return;
        }

        if (!empty($this->course?->certificate_id)) {
            generate_certificate(template_id: $this->course?->certificate_id, generated_for_type: User::class, generated_for_id: auth()->user()->id, wildcard_data: $wildcard_data);
        }
    }
}
