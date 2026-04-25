<?php

namespace Modules\Quiz\Livewire\Pages\Student\QuizAttempt;

use App\Jobs\GenerateCertificateJob;
use App\Jobs\SendDbNotificationJob;
use App\Jobs\SendNotificationJob;
use App\Models\User;
use App\Models\UserSubjectGroupSubject;
use App\Models\UserSubjectSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Quiz\Models\Question;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Models\QuizAttempt as ModelsQuizAttempt;
use Modules\Quiz\Services\QuestionService;
use Modules\Quiz\Services\QuizService;
use Modules\Upcertify\Models\Certificate;

class QuizAttempt extends Component
{
    public $attemptId;
    public $quiz;
    public User $user;
    public $course;
    public Question $question;
    public $quizAttempt;
    public $answer = null;
    public $questions;
    public $questionIndex = 0;
    public $blanks = [];

    public $questionNumber = 1;

    // Timer
    public $duration        = 0;
    public $elapsedTime     = 0;
    public $remainingTime   = 0;
    public $animateClass = 'am-animate-fadeinup';
    protected QuizService $quizService;
    protected QuestionService $questionService;

    public function boot(QuizService $quizService, QuestionService $questionService)
    {
        $this->quizService      = $quizService;
        $this->questionService  = $questionService;
        $this->user             = Auth::user();
    }

    /**
     * Mount the component with the provided quiz ID.
     *
     * @param int $attemptId
     * @return void
     */
    public function mount($attemptId)
    {
        $this->attemptId = $attemptId;

        if (!is_numeric($this->attemptId)) {
            abort(404);
        }

        $this->quizAttempt = $this->quizService->getAttemptedQuiz(
            select: ['id', 'quiz_id', 'student_id', 'started_at', 'completed_at', 'active_question_id', 'total_questions', 'result', 'created_at', 'updated_at'],
            relations: [
                'quiz:id,tutor_id,quizzable_type,quizzable_id,title,description,status',
                'quiz.quizzable',
                'quiz.questions:id,quiz_id,title,type,description,settings',
                'quiz.questions.options:id,question_id,option_text,is_correct',
                'quiz.questions.options.image:mediable_id,mediable_type,type,path',
                'quiz.questions.thumbnail:mediable_id,mediable_type,type,path',
                'quiz.tutor.profile:id,user_id,slug',
                'quiz.settings:quiz_id,meta_key,meta_value,created_at,updated_at',
            ],
            attemptId: $this->attemptId,
            withCount: ['quiz' => fn($q) => $q->withCount('questions')],
            withSum: [
                ['quiz' => fn($q) => $q->withSum('questions', 'points'), 'total_points', 'points'],
            ],
            studentId: $this->user->id,
            filters: ['status' => ModelsQuizAttempt::ASSIGNED]
        );

        if (empty($this->quizAttempt) || empty($this->quizAttempt->quiz)) {
            abort(404);
        }

        if (empty($this->quizAttempt->active_question_id)) {
            $this->quizService->updateActiveQuestion(
                quizAttempt: $this->quizAttempt,
                activeQuestionId: $this->quizAttempt->quiz->questions->first()->id,
                started_at: now()
            );
        }

        if (!empty($this->quizAttempt->quiz->settings?->where('meta_key', 'duration')->first()?->meta_value) && is_string($this->quizAttempt->quiz->settings?->where('meta_key', 'duration')->first()?->meta_value)) {
            $this->duration = getDurationInSeconds($this->quizAttempt->quiz->settings?->where('meta_key', 'duration')->first()?->meta_value);
        }

        $this->questions = $this->quizAttempt->quiz?->questions;



        // Get active question from quiz attempt
        if ($this->quizAttempt && $this->quizAttempt->active_question_id) {
            $this->questionIndex = $this->questions->search(function ($question) {
                return $question->id == $this->quizAttempt->active_question_id;
            });
            if ($this->questionIndex === false) {
                $this->questionIndex = 0;
            }
            $this->questionNumber = $this->questionIndex + 1;
        }

        $this->question = $this->questions[$this->questionIndex];
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    #[Layout('quiz::layouts.quiz')]
    public function render()
    {
        $this->elapsedTime = now()->timestamp - $this->quizAttempt?->started_at?->timestamp ?? 0;
        $this->remainingTime = $this->duration - $this->elapsedTime;
        if ($this->remainingTime < 0) {
            $this->finishQuiz();
        }
        return view('quiz::livewire.student.quiz-attempt.quiz-attempt', []);
    }


    public function submitQuestion()
    {
        // is multiple choice question
        if ($this->question->isMultiOption()) {
            if ($this->question->isMultiOption() && !empty($this->question->settings['answer_required']) && $this->answer == null) {
                return $this->dispatch(
                    'showAlertMessage',
                    type: 'error',
                    title: __('quiz::quiz.answer_required'),
                    message: __('quiz::quiz.answer_required_text')
                );
            }

            $this->submitMultipOptionQustion();
        }

        //is descriptive question
        if ($this->question->isDescriptive()) {   
            if ($this->question->isDescriptive() && !empty($this->question->settings['answer_required']) && empty($this->answer)) {
                return $this->dispatch(
                    'showAlertMessage',
                    type: 'error',
                    title: __('quiz::quiz.answer_required'),
                    message: __('quiz::quiz.answer_required_text')
                );
            }

            $this->submitDescriptiveQustion();
        }

        //is fill in blanks question
        if ($this->question->isFillInBlanks()) {
            if ($this->question->isFillInBlanks() && !empty($this->question->settings['answer_required']) && empty($this->blanks)) {
                return $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.answer_required'), message: __('quiz::quiz.answer_required_text'));
            }

            $this->submitFillInBlanksQustion();
        }


        $this->answer = null;
        $this->blanks = [];
        if ($this->question->is($this->questions->last())) {
            return $this->finishQuiz();
        }


        $this->questionIndex    = $this->questionIndex + 1;
        $this->questionNumber   = $this->questionNumber + 1;

        $this->question = $this->questions[$this->questionIndex];

        // Update active question in database
        if ($this->quizAttempt) {
            $this->quizAttempt->update([
                'active_question_id' => $this->question->id
            ]);
        }
    }

    private function submitMultipOptionQustion()
    {
        $isCorrect = $this->answer == $this->question->options?->where('is_correct', '1')->first()?->id;

        $questionAttemptData = [
            'quiz_attempt_id'       => $this->quizAttempt->id,
            'question_id'           => $this->question->id,
            'question_option_id'    => $this->answer,
            'answer'                => null,
            'is_correct'            => $isCorrect,
            'marks_awarded'         => $isCorrect ? $this->question->points : 0
        ];

        $this->questionService->createQuestionAttempt($questionAttemptData);
    }

    private function submitDescriptiveQustion()
    {
        $answerText = sanitizeTextField($this->answer);
        $questionAttemptData = [
            'quiz_attempt_id'       => $this->quizAttempt->id,
            'question_id'           => $this->question->id,
            'answer'                => $answerText,
        ];

        $this->questionService->createQuestionAttempt($questionAttemptData);
    }

    private function submitFillInBlanksQustion()
    {
        $blank_answer   = SanitizeArray($this->blanks);
        $answer         = array_map('trim', array_map('strtolower', $blank_answer));
        $options        = array_map('trim', array_map('strtolower', $this->question->options->pluck('option_text')->toArray()));

        $isCorrect  = $answer == $options;

        $questionAttemptData = [
            'quiz_attempt_id'       => $this->quizAttempt->id,
            'question_id'           => $this->question->id,
            'is_correct'            => $isCorrect,
            'answer'                => implode('|', $blank_answer),
            'marks_awarded'         => $isCorrect ? $this->question->points : 0
        ];

        $this->questionService->createQuestionAttempt($questionAttemptData);
    }

    public function finishQuiz()
    {
        $generateResult = $this->quizAttempt?->quiz->settings?->where('meta_key', 'auto_result_generate')?->where('meta_value', '1')->isNotEmpty();

        $studentId = Auth::user()->id;
        $student = User::with('profile')->find($studentId);

        $quizAttempt = $this->quizService->getAttemptedQuiz(
            attemptId: $this->quizAttempt?->id,
            relations: [
                'attemptedQuestions:quiz_attempt_id,question_id,answer,is_correct,marks_awarded',
                'quiz.tutor.profile'
            ],
        );

        if (!empty($generateResult)) {
            $passingGrade           = $this->quizAttempt?->quiz->settings?->where('meta_key', 'passing_grade')->first()?->meta_value ?? 0;
            $correctAnswers         = $quizAttempt->attemptedQuestions->where('is_correct', true)->count();
            $inCorrectAnswers       = $quizAttempt->attemptedQuestions->where('is_correct', false)->count();
            $earnedMarks            = $quizAttempt->attemptedQuestions->sum('marks_awarded');
        }

        try {
            DB::beginTransaction();

            if (!empty($generateResult)) {
                $quizAttemptData = [
                    'correct_answers'           => $correctAnswers,
                    'incorrect_answers'         => $inCorrectAnswers,
                    'earned_marks'              => $earnedMarks,
                    'completed_at'              => now(),
                ];
                $quizAttempt->update($quizAttemptData);
                $percentageMarks = $earnedMarks / $this->quizAttempt->total_marks * 100;
                $percentageMarks = round($percentageMarks, 2);

                $quizAttempt->result  = $percentageMarks >= $passingGrade ? 'pass' : 'fail';

                $quizAttempt->save();




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

                DB::commit();

                if (isActiveModule('Upcertify') && $quizAttempt->result == 'pass') {
                    $allQuizAttempts = ModelsQuizAttempt::where('student_id', auth()->user()?->id)
                        ->whereHas('quiz', function ($query) {
                            $query->where('quizzable_id', $this->quizAttempt?->quiz?->quizzable_id)
                                ->where('quizzable_type', $this->quizAttempt?->quiz?->quizzable_type);
                        })
                        ->where('result', '<>', ModelsQuizAttempt::PASS)
                        ->exists();
                    if (isActiveModule('Courses') && $this->quizAttempt->quiz?->quizzable_type == \Modules\Courses\Models\Course::class) {

                        $this->course = $this->quizAttempt->quiz?->quizzable;

                        $metaData = $this->course->meta_data['assign_quiz_certificate'] ?? null;

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
                                        $booking = $slot->bookings->whereStudentId(auth()?->user()?->id)->first();
                                        if ($booking) {
                                            dispatch(new GenerateCertificateJob($booking));
                                        }
                                    }
                                    if ($slot->metadata['assign_quiz_certificate'] == 'all') {
                                        if (!$allQuizAttempts) {
                                            $booking = $slot->bookings->whereStudentId(auth()?->user()?->id)->first();
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
            } else {
                $quizAttempt->completed_at  = now();
                $quizAttempt->result        = ModelsQuizAttempt::RESULT_IN_REVIEW;

                $emailData = [
                    'quizTitle'       => $quizAttempt?->quiz?->title,
                    'studentName'     => $student?->profile?->full_name,
                    'tutorName'       => $quizAttempt?->quiz?->tutor?->profile?->full_name,
                ];

                $notifyData = [
                    'quizTitle'       => $quizAttempt?->quiz?->title,
                    'studentName'     => $student?->profile?->full_name,
                    'tutorName'       => $quizAttempt?->quiz?->tutor?->profile?->full_name,
                ];

                dispatch(new SendNotificationJob('reviewedQuiz', $quizAttempt?->quiz?->tutor, $emailData));
                dispatch(new SendDbNotificationJob('reviewedQuiz', $quizAttempt?->quiz?->tutor, $notifyData));

                $quizAttempt->save();

                DB::commit();
            }

            $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.quiz_finished'), message: __('quiz::quiz.quiz_finished_successfully'));

            return redirect()->route('quiz.quiz-result', ['attemptId' => $this->quizAttempt->id]);
        } catch (\Throwable $th) {
            Log::error($th);
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.quiz_finished'), message: __('general.error_msg'));
            DB::rollBack();
        }
    }

    #[On('back-to-quiz-list')]
    public function goBack()
    {
        // $this->redirect(route('quiz.quiz-result', ['attemptId' => $this->attemptId]));
    }

    public function generateCertificate()
    {

        $wildcard_data = [
            'tutor_name'         => $this->course?->instructor?->profile?->full_name ?? '',
            'student_name'       => auth()->user()->profile?->full_name ?? '',
            'gender'             => !empty(auth()->user()->profile?->gender) ? ucfirst(auth()->user()->profile?->gender) : '',
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
            'student_email'      => auth()->user()->email ?? '',
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
