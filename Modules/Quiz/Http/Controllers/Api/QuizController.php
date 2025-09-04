<?php

namespace Modules\Quiz\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\Quiz\Models\Question;
use App\Jobs\GenerateCertificateJob;
use App\Models\UserSubjectGroupSubject;
use App\Services\BookingService;
use Modules\Quiz\Models\Quiz;
use Modules\Upcertify\Models\Certificate;
use App\Models\User;
use Carbon\Carbon;
use Modules\Quiz\Http\Requests\QuizSettingRequest;
use Modules\Quiz\Services\QuizService;
use Modules\Quiz\Http\Resources\QuizAttemptsResource;
use Modules\Quiz\Models\QuizAttempt as ModelsQuizAttempt;
use Modules\Quiz\Services\QuestionService;
use Modules\Quiz\Http\Resources\QuestionResource;
use Modules\Quiz\Http\Requests\AiQuizRequest;
use App\Jobs\SendNotificationJob;
use App\Jobs\SendDbNotificationJob;
use App\Services\SubjectService;
use Modules\Quiz\Models\QuizAttempt;
use Modules\Quiz\Http\Requests\MarkQuizRequest;
use Modules\Quiz\Http\Resources\QuizzesCollection;
use Modules\Quiz\Http\Resources\QuizResource;
use Modules\Quiz\Http\Resources\QuizAttemptsCollection;
use Modules\Quiz\Http\Requests\QuizRequest;
use Modules\Quiz\Http\Resources\QuizResultResource;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{
    use ApiResponser;

    protected $quizService;
    protected $questionService;
    public function __construct()
    {
        $this->questionService = new QuestionService();
        $this->quizService = new QuizService();
    }

    public function getCourses(Request $request)
    {
        try {
            $courses = (new \Modules\Courses\Services\CourseService())->getInstructorCourses(Auth::id(), [], ['title', 'id']);
            return $this->success(data: $courses, code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function getSubjects(Request $request)
    {
        try {
            $subjectGroups = (new SubjectService(Auth::user()))->getUserSubjectGroups(['subjects:id,name', 'group:id,name']);
            $formattedData = [];
            foreach ($subjectGroups as $sbjGroup) {
                if ($sbjGroup->subjects->isEmpty()) {
                    continue;
                }
                $groupData = [
                    'text' => $sbjGroup->group->name,
                    'children' => []
                ];

                if ($sbjGroup->subjects) {
                    foreach ($sbjGroup->subjects as $sbj) {
                        $groupData['children'][] = [
                            'id' => $sbj->pivot->id,
                            'text' => $sbj->name,
                        ];
                    }
                }
                $formattedData[] = $groupData;
            }
            return $this->success(data: $formattedData, code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function getSessions(Request $request)
    {
        try {
            $id = $request->query('id');
            if (!$id) {
                return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
            }

            $dateFormat        = setting('_general.date_format');
            $timeFormat        = setting('_lernen.time_format');

            $user_subject_slots = [];
            $slots = (new BookingService(Auth::user()))->getAvailableSubjectSlots($id, $dateFormat, $timeFormat);

            if (!$slots) {
                return $this->error(message: __('quiz::quiz.no_slots_found'), code: Response::HTTP_NOT_FOUND);
            }

            foreach ($slots as $slot) {
                $user_subject_slots[] = ['value' => $slot['id'], 'text' => $slot['text']];
            }

            return $this->success(data: $user_subject_slots, code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function getQuizzes(Request $request)
    {
        try {
            $quizzes = $this->quizService->getQuizzesList($request->all());
            return $this->success(data: new QuizzesCollection($quizzes), code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function duplicateQuiz(Request $request)
    {
        if ($response = $this->blockIfDemoSite()) return $response;

        $validatedQuiz = $this->validateQuizAccess($request->id);
        if (!$validatedQuiz['success']) {
            return $validatedQuiz['response'];
        }

        $quiz = $validatedQuiz['response'];

        try {
            $quiz = $this->quizService->duplicateQuiz($request->id);
            if (!$quiz) {
                return $this->error(message: __('quiz::quiz.quiz_not_duplicated'), code: Response::HTTP_BAD_REQUEST);
            } else {
                return $this->success(message: __('quiz::quiz.quiz_duplicated_successfully'), code: Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function publishQuiz(Request $request)
    {
        if ($response = $this->blockIfDemoSite()) return $response;

        $validatedQuiz = $this->validateQuizAccess($request->id, ['questions']);
        if (!$validatedQuiz['success']) {
            return $validatedQuiz['response'];
        }

        $quiz = $validatedQuiz['response'];

        if ($quiz->questions->isEmpty()) {
            return $this->error(message: __('quiz::quiz.quiz_has_no_questions'), code: Response::HTTP_BAD_REQUEST);
        }

        if ($quiz->status != Quiz::STATUS_DRAFT) {
            return $this->error(message: __('quiz::quiz.quiz_not_draft'), code: Response::HTTP_BAD_REQUEST);
        }

        $publishedQuiz = $this->quizService->publishQuiz($quiz->id);

        $quiz = Quiz::where('id', $quiz->id)->first();
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

        if ($publishedQuiz) {
            return $this->success(message: __('quiz::quiz.quiz_published_successfully'), code: Response::HTTP_OK);
        } else {
            return $this->error(message: __('quiz::quiz.quiz_not_published'), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function quizStatus(Request $request)
    {
        if ($response = $this->blockIfDemoSite()) return $response;

        $validatedQuiz = $this->validateQuizAccess($request->id);
        if (!$validatedQuiz['success']) {
            return $validatedQuiz['response'];
        }

        $quiz = $validatedQuiz['response'];

        if (in_array($quiz->status, ['draft'])) {
            return $this->error(message: __('quiz::quiz.draft_quiz_cannot_be_archived'), code: Response::HTTP_BAD_REQUEST);
        }

        try {
            $status = $quiz->status === 'archived' ? 'published' : 'archived';
            $quiz = $this->quizService->archivedQuiz($request->id, $status);
            if ($quiz) {
                if ($status == 'published') {
                    return $this->error(message: __('quiz::quiz.quiz_unarchived_successfully'), code: Response::HTTP_OK);
                } else {
                    return $this->error(message: __('quiz::quiz.quiz_archived_successfully'), code: Response::HTTP_OK);
                }
            }
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function quizAttempts(Request $request)
    {
        if ($response = $this->blockIfDemoSite()) return $response;

        $validatedQuiz = $this->validateQuizAccess($request->id);
        if (!$validatedQuiz['success']) {
            return $validatedQuiz['response'];
        }

        $filter = $request->all();

        $statusMap = [
            QuizAttempt::RESULT_ASSIGNED   => QuizAttempt::ASSIGNED,
            QuizAttempt::RESULT_IN_REVIEW => QuizAttempt::IN_REVIEW,
            QuizAttempt::RESULT_PASSED    => QuizAttempt::PASS,
            QuizAttempt::RESULT_FAILED    => QuizAttempt::FAIL,
        ];

        if (isset($filter['status']) && isset($statusMap[$filter['status']])) {
            $filter['status'] = $statusMap[$filter['status']];
        }
        try {
            $quizAttempts = $this->quizService->getAttemptedQuizzes(
                select: [
                    'id',
                    'quiz_id',
                    'student_id',
                    'started_at',
                    'total_marks',
                    'total_questions',
                    'correct_answers',
                    'incorrect_answers',
                    'earned_marks',
                    'result',
                    'created_at'
                ],
                relations: [
                    'quiz.quizzable',
                    'quiz.thumbnail:mediable_id,mediable_type,type,path',
                    'student.profile:id,user_id,first_name,last_name,image',
                ],
                tutorId: Auth::user()->id,
                quizId: $request->id,
                filters: $filter
            );
            return $this->success(data: new QuizAttemptsCollection($quizAttempts), code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function createQuiz(QuizRequest $request)
    {
        if ($response = $this->blockIfDemoSite()) return $response;

        if (isActiveModule('Courses') && $request->get('quizzable_type') === 'course') {
            $request['quizzable_type']      = \Modules\Courses\Models\Course::class;
        } else {
            $request['quizzable_type']      = UserSubjectGroupSubject::class;
        }

        $request['user_subject_slots']  = $request->get('user_subject_slots') ?? [];
        $request['status']              = 'draft';

        try {
            $quiz = $this->quizService->createQuiz($request->all());
            if ($quiz) {
                return $this->success(data: new QuizResource($quiz), message: __('quiz::quiz.quiz_created_successfully'), code: Response::HTTP_OK);
            } else {
                return $this->error(message: __('quiz::quiz.quiz_not_created'), code: Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateQuiz(QuizRequest $request)
    {
        if ($response = $this->blockIfDemoSite()) return $response;

        $validatedQuiz = $this->validateQuizAccess($request->id);
        if (!$validatedQuiz['success']) {
            return $validatedQuiz['response'];
        }

        $quiz = $validatedQuiz['response'];

        if (!in_array($quiz->status, ['draft'])) {
            return $this->error(message: __('quiz::quiz.quiz_cannot_be_updated'), code: Response::HTTP_BAD_REQUEST);
        }

        if (isActiveModule('Courses') && $request->get('quizzable_type') === 'course') {
            $request['quizzable_type']      = \Modules\Courses\Models\Course::class;
        } else {
            $request['quizzable_type']      = UserSubjectGroupSubject::class;
        }

        $request['user_subject_slots']  = $request->get('user_subject_slots') ?? [];

        try {
            $quiz = $this->quizService->updateQuiz($request->id, $request->all());
            if ($quiz) {
                return $this->success(data: new QuizResource($quiz), message: __('quiz::quiz.quiz_updated_successfully'), code: Response::HTTP_OK);
            } else {
                return $this->error(message: __('quiz::quiz.quiz_not_updated'), code: Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function quizSettings(QuizSettingRequest $request)
    {
        if ($response = $this->blockIfDemoSite()) return $response;

        $validatedQuiz = $this->validateQuizAccess($request->id);
        if (!$validatedQuiz['success']) {
            return $validatedQuiz['response'];
        }

        $quiz = $validatedQuiz['response'];

        if ($quiz->status == Quiz::STATUS_ARCHIVED || $quiz->status == Quiz::STATUS_PUBLISHED) {
            return $this->error(message: __('quiz::quiz.quiz_is_archived_or_published'), code: Response::HTTP_BAD_REQUEST);
        }

        $data = [
            'duration'                  => $request->hours . ':' . $request->minutes,
            'hide_quiz_timer'           => $request->hide_Quiz ? 1 : 0,
            'attempts_allowed'          => 1,
            'passing_grade'             => $request->passing_grade,
            'question_order'            => $request->question_order,
            'hide_question_number'      => $request->hide_question ? 1 : 0,
            'short_ans_limit'           => $request->limit_short_answers,
            'max_ans_limit'             => $request->limit_max_answers,
            'auto_result_generate'      => $request->auto_result_generate ? 1 : 0,
        ];
        try {
            $quizSetting = $this->quizService->addQuizSettings($request->id, $data);
            if ($quizSetting) {
                return $this->success(message: __('quiz::quiz.quiz_settings_updated_successfully'), code: Response::HTTP_OK);
            } else {
                return $this->error(message: __('quiz::quiz.quiz_settings_not_updated'), code: Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function getQuizSettings(Request $request)
    {
        $validatedQuiz = $this->validateQuizAccess($request->id);
        if (!$validatedQuiz['success']) {
            return $validatedQuiz['response'];
        }


        try {
            $quizSettings = $this->quizService->getQuizSettings($request->id);
            return $this->success(data: $quizSettings, message: __('quiz::quiz.quiz_settings_retrieved_successfully'), code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function getQuiz(Request $request)
    {
        if (!$request->id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }
        try {
            $quiz = $this->quizService->getQuiz(
                select: ['id', 'title', 'quizzable_type', 'quizzable_id', 'user_subject_slots', 'description', 'status'],
                quizId: $request->id,
                tutorId: Auth::user()->id,
            );

            if (!$quiz) {
                return $this->error(message: __('quiz::quiz.quiz_not_found'), code: Response::HTTP_NOT_FOUND);
            }

            return $this->success(data: new QuizResource($quiz), message: __('quiz::quiz.quiz_details_retrieved_successfully'), code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function quizQuestions(Request $request)
    {
        if (!$request->attempt_id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $attemptQuiz = $this->quizService->getStudentAttemptedQuiz(
            attemptId: $request->attempt_id,
            statuses: [QuizAttempt::IN_REVIEW],
            role: Auth::user()->role,
            userId: Auth::user()->id,
        );
        if (!$attemptQuiz) {
            return $this->error(message: __('quiz::quiz.attempt_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if ($attemptQuiz->quiz->tutor_id != Auth::user()->id) {
            return $this->error(message: __('quiz::quiz.not_authorized'), code: Response::HTTP_FORBIDDEN);
        }

        $completedDuration = Carbon::parse($attemptQuiz->started_at)->diffInSeconds(Carbon::parse($attemptQuiz->completed_at));
        $hours             = floor(intval($completedDuration) / 3600);

        if (!empty($hours)) {
            $duration = getDurationFormatted(intval($completedDuration)) . ' ' . __('quiz::quiz.hrs');
        } else {
            $duration = getDurationFormatted(intval($completedDuration)) . ' ' . __('quiz::quiz.time_min');
        }

        $questions = $attemptQuiz?->quiz?->questions;

        if ($questions->isEmpty()) {
            return $this->error(message: __('quiz::quiz.quiz_has_no_questions'), code: Response::HTTP_NOT_FOUND);
        }

        return $this->success(
            data: [
                'questions' => QuestionResource::collection($questions),
                'duration'  => $duration,
            ],
            message: __('quiz::quiz.quiz_questions_retrieved_successfully'),
            code: Response::HTTP_OK
        );
    }

    public function markQuiz(MarkQuizRequest $request)
    {
        if (!$request->attempt_id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }



        $attemptQuiz = $this->getStudentAttemptedQuiz(
            attemptId: $request->attempt_id,
            statuses: [QuizAttempt::IN_REVIEW],
        );

        if (!$attemptQuiz) {
            return $this->error(message: __('quiz::quiz.attempt_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        // Count open ended essay and short answer questions
        $openEndedAndShortQuestions = $attemptQuiz->quiz->questions()
            ->whereIn('type', [Question::TYPE_OPEN_ENDED_ESSAY, Question::TYPE_SHORT_ANSWER])
            ->count();

        if ($openEndedAndShortQuestions > 0) {
            if (!is_array($request->answers)) {
                return $this->error(message: __('quiz::quiz.answers_required'), code: Response::HTTP_BAD_REQUEST);
            }

            if (count($request->answers) != $openEndedAndShortQuestions) {
                return $this->error(message: __('quiz::quiz.answers_required'), code: Response::HTTP_BAD_REQUEST);
            }

            foreach ($request->answers as $answer) {
                if (!isset($answer['question_id']) || !isset($answer['marks_awarded'])) {
                    return $this->error(message: __('quiz::quiz.invalid_answer_format'), code: Response::HTTP_BAD_REQUEST);
                }

                if (!is_numeric($answer['marks_awarded']) || $answer['marks_awarded'] < 0) {
                    return $this->error(message: __('quiz::quiz.invalid_marks'), code: Response::HTTP_BAD_REQUEST);
                }
            }
        }

        if ($attemptQuiz->quiz->tutor_id != Auth::user()->id) {
            return $this->error(message: __('quiz::quiz.not_authorized'), code: Response::HTTP_FORBIDDEN);
        }

        $questionTypes      = [Question::TYPE_OPEN_ENDED_ESSAY, Question::TYPE_SHORT_ANSWER];
        $quizQuestions      = $attemptQuiz->quiz?->questions ?? collect();
        $quizQuestionMap    = $quizQuestions->keyBy('id');

        try {
            DB::beginTransaction();
            if (!empty($request->answers)  && is_array($request->answers)) {
                foreach ($request->answers as $answer) {

                    $questionId = $answer['question_id'] ?? null;
                    $question   = $quizQuestionMap->get($questionId);

                    if (!$question || !in_array($question->type, $questionTypes)) {
                        return $this->error(message: __('quiz::quiz.invalid_question_id', ['id' => $questionId]), code: Response::HTTP_BAD_REQUEST);
                    }

                    $marksAwarded = $answer['marks_awarded'] ?? null;

                    $requiredAnswers = [
                        'quiz_attempt_id' => $attemptQuiz->id,
                        'question_id'     => $questionId,
                        'is_correct'      => $marksAwarded > 0 ? 1 : 0,
                        'marks_awarded'   => $marksAwarded,
                    ];
                    $this->questionService->createQuestionAttempt($requiredAnswers);
                }
            }

            $quizAttempt = $this->quizService->getQuizAttempt(
                $attemptQuiz->id,
                [
                    'attemptedQuestions',
                    'quiz.tutor.profile',
                    'quiz.tutor.profile',
                    'student.profile'
                ]
            );

            $quizAttempt = $this->getStudentAttemptedQuiz(
                attemptId: $attemptQuiz->id,
                statuses: [QuizAttempt::IN_REVIEW, QuizAttempt::PASS, QuizAttempt::FAIL],
            );

            if (empty($quizAttempt)) {
                return $this->error(message: __('quiz::quiz.quiz_attempt_not_found'), code: Response::HTTP_NOT_FOUND);
            }

            $passingGrade       = $quizAttempt->quiz->settings?->where('meta_key', 'passing_grade')->first()?->meta_value ?? 0;
            $correctAnswers     = $quizAttempt->attemptedQuestions->where('is_correct', true)->count();
            $inCorrectAnswers   = $quizAttempt->attemptedQuestions->where('is_correct', false)->count();
            $earnedMarks        = $quizAttempt->attemptedQuestions->sum('marks_awarded');

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

            // $this->assignCertificate();

            DB::commit();

            return $this->success(message: __('quiz::quiz.quiz_submitted_successfully'), code: Response::HTTP_OK);
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->error(message: $ex->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function quizResult(Request $request)
    {
        if (!$request->attempt_id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $quizAttempt = $this->getStudentAttemptedQuiz(
            attemptId: $request->attempt_id,
            statuses: [QuizAttempt::PASS, QuizAttempt::FAIL],
        );

        if (!$quizAttempt) {
            return $this->error(message: __('quiz::quiz.attempt_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if (Auth::user()->role == 'student' && $quizAttempt?->student_id != Auth::user()->id) {
            return $this->error(message: __('quiz::quiz.not_authorized'), code: Response::HTTP_FORBIDDEN);
        }

        if (Auth::user()->role == 'tutor' && $quizAttempt?->quiz?->tutor_id != Auth::user()->id) {
            return $this->error(message: __('quiz::quiz.not_authorized'), code: Response::HTTP_FORBIDDEN);
        }

        $completedAt = \Carbon\Carbon::parse($quizAttempt?->completed_at)->format('F j, Y @ h:i A');

        return $this->success(
            data: [
                'quiz_attempt' => new QuizResultResource($quizAttempt),
                'completed_at' => $completedAt
            ],
            code: Response::HTTP_OK
        );
    }

    public function generateAiQuiz(AiQuizRequest $request)
    {
        if ($response = $this->blockIfDemoSite()) return $response;

        if (empty(setting('_api.openai_api_key'))) {
            return $this->error(message: __('general.openai_api_key_missing'), code: Response::HTTP_BAD_REQUEST);
        }

        if (isActiveModule('Courses') && $request->get('quizzable_type') === 'course') {
            $request['quizzable_type']      = \Modules\Courses\Models\Course::class;
        } else {
            $request['quizzable_type']      = UserSubjectGroupSubject::class;
        }

        $request['user_subject_slots']  = $request->get('user_subject_slots') ?? null;
        $request['status']              = 'draft';
        $hasAtLeastOneQuestion          = false;

        foreach ($request->question_types as $key => $value) {
            if (!empty($value) && $value > 0) {
                $hasAtLeastOneQuestion = true;
            }
        }

        if (!$hasAtLeastOneQuestion) {
            return $this->error(message: __('quiz::quiz.question_types_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $quizResp = $this->quizService->createAiQuiz(array_merge($request->all()));

        if (!$quizResp['success']) {
            return $this->error(message: $quizResp['message'], code: Response::HTTP_BAD_REQUEST);
        } else {
            return $this->success(message: $quizResp['message'], data: ['quiz_id' => $quizResp['quiz']->id], code: Response::HTTP_OK);
        }
    }

    public function generateAiQuizSettings()
    {
        try {
            $generateAiQuizSettings = [
                'max_mcq'           => setting('_quiz.max_number_of_mcq_questions_by_ai') ?? 5,
                'max_true_false'    => setting('_quiz.max_number_of_true_false_questions_by_ai') ?? 5,
                'max_fill_blanks'   => setting('_quiz.max_number_of_fill_in_blanks_questions_by_ai') ?? 5,
                'max_short_answer'  => setting('_quiz.max_number_of_short_answer_questions_by_ai') ?? 5,
                'max_open_ended'    => setting('_quiz.max_number_of_open_ended_essay_questions_by_ai') ?? 5,
            ];

            return $this->success(data: $generateAiQuizSettings, code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    function getStudentAttemptedQuiz($attemptId, $statuses)
    {
        return $this->quizService->getStudentAttemptedQuiz(
            attemptId: $attemptId,
            statuses: $statuses,
            role: Auth::user()->role,
            userId: Auth::user()->id,
        );
    }

    private function blockIfDemoSite()
    {
        if (isDemoSite()) {
            return $this->error(__('general.demosite_res_txt'), Response::HTTP_BAD_REQUEST);
        }
        return false;
    }

    private function validateQuizAccess($quizId, $relations = [])
    {
        if (!$quizId) {
            return [
                'success'   => false,
                'response'  => $this->error(__('quiz::quiz.id_required'), Response::HTTP_BAD_REQUEST)
            ];
        }

        $quiz = $this->quizService->getQuiz(['*'], $quizId, relations: $relations);

        if (!$quiz) {
            return [
                'success'   => false,
                'response'  => $this->error(__('quiz::quiz.quiz_not_found'), Response::HTTP_NOT_FOUND)
            ];
        }

        if (Auth::user()->id != $quiz->tutor_id) {
            return [
                'success'   => false,
                'response'  => $this->error(__('quiz::quiz.not_authorized'), Response::HTTP_FORBIDDEN)
            ];
        }

        return [
            'success'   => true,
            'response'  => $quiz
        ];
    }

    // student

    public function getStudentQuizzes(Request $request)
    {
        try {
            $quizAttempts = $this->quizService->getAttemptedQuizzes(
                select: [
                    'id',
                    'quiz_id',
                    'student_id',
                    'started_at',
                    'total_marks',
                    'correct_answers',
                    'incorrect_answers',
                    'earned_marks',
                    'total_questions',
                    'result',
                ],
                relations: [
                    'quiz' => function ($query) {
                        $query->select('id', 'title', 'quizzable_id', 'quizzable_type', 'created_at');
                        $query->withCount(['questions', 'quizAttempts']);
                        $query->with([
                            'settings',
                            'quizzable',
                            'thumbnail:mediable_id,mediable_type,type,path',
                        ]);
                    }
                ],
                studentId: Auth::user()->id,
                filters: $request->all()
            );
            return $this->success(data: new QuizAttemptsCollection($quizAttempts), code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function getStudentQuiz(Request $request)
    {

        if (!$request->attempt_id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $quizAttempt = $this->quizService->getQuizAttempt($request->attempt_id);
        if (!$quizAttempt) {
            return $this->error(message: __('quiz::quiz.attempt_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        try {
            $quizAttempt = $this->quizService->getAttemptedQuiz(
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
                attemptId: $request->attempt_id,
                withSum: [
                    ['quiz' => fn($q) => $q->withSum('points'), 'total_points', 'points'],
                ],
                studentId: Auth::user()->id,
            );

            return $this->success(data: new QuizAttemptsResource($quizAttempt), message: __('quiz::quiz.quiz_result_retrieved_successfully'), code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function startQuiz(Request $request)
    {
        if (!$request->attempt_id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $quizAttempt = $this->quizService->getQuizAttempt($request->attempt_id);

        if (!$quizAttempt) {
            return $this->error(message: __('quiz::quiz.attempt_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if (!empty($quizAttempt) && !empty($quizAttempt->started_at) && !empty($quizAttempt->active_question_id)) {
            return  $this->success(message: __('quiz::quiz.already_started'), code: Response::HTTP_OK);
        }

        $quizAttempt = $this->quizService->startQuiz($quizAttempt->quiz_id);

        if (!$quizAttempt) {
            return $this->error(message: __('quiz::quiz.quiz_not_started'), code: Response::HTTP_BAD_REQUEST);
        }

        return $this->success(message: __('quiz::quiz.quiz_started_successfully'), code: Response::HTTP_OK);
    }

    public function getQuizInstructions()
    {
        return $this->success(data: setting('_quiz.quiz_instructions'), code: Response::HTTP_OK);
    }

    public function getQuizInReview(Request $request)
    {
        if (!$request->attempt_id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $quizAttempt = $this->quizService->getAttemptedQuiz(
            select: ['id', 'quiz_id', 'student_id', 'started_at', 'completed_at', 'result'],

            attemptId: $request->attempt_id,

            studentId: Auth::user()->id,
            filters: ['status' => ModelsQuizAttempt::IN_REVIEW]
        );

        if (!$quizAttempt) {
            return $this->error(message: __('quiz::quiz.attempt_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if (empty($quizAttempt->quiz)) {
            return $this->error(message: __('quiz::quiz.quiz_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        return $this->success(data: new QuizAttemptsResource($quizAttempt), code: Response::HTTP_OK);
    }

    public function getQuizAttempt(Request $request)
    {
        if (!$request->attempt_id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $quizAttempt = $this->quizService->getAttemptedQuiz(
            select: ['id', 'quiz_id', 'student_id', 'started_at', 'completed_at', 'active_question_id', 'total_questions', 'result', 'created_at', 'updated_at'],
            attemptId: $request->attempt_id,
            studentId: Auth::user()->id,
            filters: ['status' => ModelsQuizAttempt::ASSIGNED]
        );

        if (!$quizAttempt) {
            return $this->error(message: __('quiz::quiz.attempt_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if (empty($quizAttempt->active_question_id)) {
            $this->quizService->updateActiveQuestion(
                quizAttempt: $quizAttempt,
                activeQuestionId: $quizAttempt->quiz->questions->first()->id,
                started_at: now()
            );
        }

        $activeQuestionId =  $quizAttempt->active_question_id;
        $activeQuestion = $this->questionService->getQuestion($activeQuestionId, [
            'options',
            'thumbnail',
            'quiz:id,tutor_id,quizzable_type,quizzable_id,title,description,status',
        ]);

        if (empty($activeQuestion->quiz)) {
            return $this->error(message: __('quiz::quiz.quiz_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if (!empty($activeQuestion->quiz->settings?->where('meta_key', 'duration')->first()?->meta_value) && is_string($quizAttempt->quiz->settings?->where('meta_key', 'duration')->first()?->meta_value)) {
            $duration = (int) getDurationInSeconds($quizAttempt->quiz->settings?->where('meta_key', 'duration')->first()?->meta_value) / 60;
        }

        return $this->success(data: [
            'question' => new QuestionResource($activeQuestion),
            'duration' => $duration ?? 0
        ], code: Response::HTTP_OK);
    }

    public function submitQuestion(Request $request)
    {
        if (!$request->attempt_id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $quizAttempt = $this->quizService->getQuizAttempt($request->attempt_id);

        if (!$quizAttempt) {
            return $this->error(message: __('quiz::quiz.attempt_not_found'), code: Response::HTTP_NOT_FOUND);
        }
        $quizAttempt = $this->quizService->getAttemptedQuiz(
            select: ['id', 'quiz_id', 'student_id', 'started_at', 'completed_at', 'active_question_id', 'total_questions', 'result', 'created_at', 'updated_at'],
            relations: [
                'quiz:id,tutor_id,quizzable_type,quizzable_id,title,description,status',
                'quiz.quizzable',
                'quiz.questions:id,quiz_id,title,type,description,settings,points',
                'quiz.questions.options:id,question_id,option_text,is_correct',
                'quiz.questions.options.image:mediable_id,mediable_type,type,path',
                'quiz.questions.thumbnail:mediable_id,mediable_type,type,path',
                'quiz.tutor.profile:id,user_id,slug',
                'quiz.settings:quiz_id,meta_key,meta_value,created_at,updated_at',
            ],
            attemptId: $request->attempt_id,
            withCount: ['quiz' => fn($q) => $q->withCount('questions')],
            withSum: [
                ['quiz' => fn($q) => $q->withSum('questions', 'points'), 'total_points', 'points'],
            ],
            studentId: Auth::user()->id,
            filters: ['status' => ModelsQuizAttempt::ASSIGNED]
        );
        if (empty($quizAttempt->quiz)) {
            return $this->error(message: __('quiz::quiz.quiz_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        $questions = $quizAttempt->quiz?->questions;

        if ($quizAttempt && $quizAttempt->active_question_id) {
            $questionIndex = $questions->search(function ($question) use ($quizAttempt) {
                return $question->id == $quizAttempt->active_question_id;
            });
        }

        $question = $questions[$questionIndex];

        if ($question->isMultiOption()) {
            if ($question->isMultiOption() && !empty($question->settings['answer_required']) && $request->answer == null) {
                return $this->error(message: __('quiz::quiz.answer_required'), code: Response::HTTP_BAD_REQUEST);
            }

            $this->submitMultipOptionQustion($request->answer, $question, $quizAttempt);
        }

        if ($question->isDescriptive()) {
            if ($question->isDescriptive() && !empty($question->settings['answer_required']) && empty($request->answer)) {
                return $this->error(message: __('quiz::quiz.answer_required'), code: Response::HTTP_BAD_REQUEST);
            }

            $this->submitDescriptiveQustion($request->answer, $question, $quizAttempt);
        }

        if ($question->isFillInBlanks()) {
            if ($question->isFillInBlanks() && !empty($question->settings['answer_required']) && empty($request->blanks)) {
                return $this->error(message: __('quiz::quiz.answer_required'), code: Response::HTTP_BAD_REQUEST);
            }

            $this->submitFillInBlanksQustion($request->blanks, $question, $quizAttempt);
        }

        if ($question->is($questions->last())) {
            return $this->finishQuiz($quizAttempt);
        }


        $questionIndex    = $questionIndex + 1;
        $question         = $questions[$questionIndex];

        if ($quizAttempt) {
            $quizAttempt->update([
                'active_question_id' => $question->id
            ]);
        }

        return $this->success(data: new QuestionResource($questions[$questionIndex - 1]), code: Response::HTTP_OK);
    }

    private function submitMultipOptionQustion($answer, $question, $quizAttempt)
    {
        $isCorrect = $answer == $question->options?->where('is_correct', '1')->first()?->id;

        $questionAttemptData = [
            'quiz_attempt_id'       => $quizAttempt->id,
            'question_id'           => $question->id,
            'question_option_id'    => $answer,
            'answer'                => null,
            'is_correct'            => $isCorrect,
            'marks_awarded'         => $isCorrect ? $question->points : 0
        ];

        $this->questionService->createQuestionAttempt($questionAttemptData);
    }

    private function submitDescriptiveQustion($answer, $question, $quizAttempt)
    {

        $questionAttemptData = [
            'quiz_attempt_id'       => $quizAttempt->id,
            'question_id'           => $question->id,
            'answer'                => $answer,
        ];

        $this->questionService->createQuestionAttempt($questionAttemptData);
    }

    private function submitFillInBlanksQustion($blanks, $question, $quizAttempt)
    {
        $answer     = array_map('trim', array_map('strtolower', $blanks));
        $options    = array_map('trim', array_map('strtolower', $question->options->pluck('option_text')->toArray()));

        $isCorrect  = $answer == $options;

        $questionAttemptData = [
            'quiz_attempt_id'       => $quizAttempt->id,
            'question_id'           => $question->id,
            'is_correct'            => $isCorrect,
            'answer'                => implode('|', $blanks),
            'marks_awarded'         => $isCorrect ? $question->points : 0
        ];

        $this->questionService->createQuestionAttempt($questionAttemptData);
    }

    private function finishQuiz($quizAttempt)
    {
        $generateResult = $quizAttempt?->quiz->settings?->where('meta_key', 'auto_result_generate')?->where('meta_value', '1')->isNotEmpty();

        $studentId = Auth::user()->id;
        $student = User::with('profile')->find($studentId);

        $quizAttempt = $this->quizService->getAttemptedQuiz(
            attemptId: $quizAttempt?->id,
            relations: [
                'attemptedQuestions:quiz_attempt_id,question_id,answer,is_correct,marks_awarded',
                'quiz.tutor.profile'
            ],
        );

        if (!empty($generateResult)) {
            $passingGrade           = $quizAttempt?->quiz->settings?->where('meta_key', 'passing_grade')->first()?->meta_value ?? 0;
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
                $percentageMarks = $earnedMarks / $quizAttempt->total_marks * 100;
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
                        ->whereHas('quiz', function ($query) use ($quizAttempt) {
                            $query->where('quizzable_id', $quizAttempt?->quiz?->quizzable_id)
                                ->where('quizzable_type', $quizAttempt?->quiz?->quizzable_type);
                        })
                        ->where('result', '<>', ModelsQuizAttempt::PASS)
                        ->exists();
                    if (isActiveModule('Courses') && $quizAttempt->quiz?->quizzable_type == \Modules\Courses\Models\Course::class) {

                        $course = $quizAttempt->quiz?->quizzable;

                        $metaData = $course->meta_data['assign_quiz_certificate'] ?? null;

                        if (!empty($metaData)) {
                            if ($metaData == 'any') {
                                $this->generateCertificate($course);
                            }

                            if ($metaData == 'all') {
                                if (!$allQuizAttempts) {
                                    $this->generateCertificate($course);
                                }
                            }
                        }
                    } elseif ($quizAttempt->quiz?->quizzable_type == UserSubjectGroupSubject::class) {
                        $slots = UserSubjectSlot::whereIn('id', $quizAttempt->quiz?->user_subject_slots)->get();

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

            return $this->success(data: __('quiz::quiz.quiz_finished'), code: Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->error(message: __('quiz::quiz.quiz_finished'), code: Response::HTTP_BAD_REQUEST);
            DB::rollBack();
        }
    }

    public function generateCertificate($course)
    {

        $wildcard_data = [
            'tutor_name'         => $course?->instructor?->profile?->full_name ?? '',
            'student_name'       => auth()->user()->profile?->full_name ?? '',
            'gender'             => !empty(auth()->user()->profile?->gender) ? ucfirst(auth()->user()->profile?->gender) : '',
            'tutor_tagline'      => $course?->instructor?->profile?->tagline ?? '',
            'issued_by'          => $course?->instructor?->profile?->full_name ?? '',
            'platform_name'      => setting('_general.site_name'),
            'platform_email'     => setting('_general.site_email'),
            'course_title'       => $course?->title ?? '',
            'course_subtitle'    => $course?->subtitle ?? '',
            'course_description' => $course?->description ?? '',
            'course_category'    => $course?->category?->name ?? '',
            'course_subcategory' => $course?->subCategory?->name ?? '',
            'course_type'        => $course?->type ?? '',
            'course_level'       => $course?->level ?? '',
            'course_language'    => $course?->language?->name ?? '',
            'free_course'        => $course?->is_free ? 'Yes' : 'No',
            'course_price'       => $course?->pricing?->price ? formatAmount($course?->pricing?->price) : '',
            'course_discount'    => $course?->pricing?->discount ? formatAmount($course?->pricing?->discount) : '',
            'issue_date'         => now()->format(setting('_general.date_format')),
            'student_email'      => auth()->user()->email ?? '',
            'tutor_email'        => $course?->instructor?->email ?? '',
        ];

        if (Certificate::where('template_id', $course?->certificate_id)->where('modelable_type', User::class)->where('modelable_id', auth()->user()->id)->exists()) {
            return;
        }

        if (!empty($course?->certificate_id)) {
            generate_certificate(template_id: $course?->certificate_id, generated_for_type: User::class, generated_for_id: auth()->user()->id, wildcard_data: $wildcard_data);
        }
    }
}
