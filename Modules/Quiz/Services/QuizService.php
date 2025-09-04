<?php

namespace Modules\Quiz\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Models\QuizSetting;
use App\Models\UserSubjectGroupSubject;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Quiz\Models\QuizAttempt;
use Modules\Quiz\Casts\QuizStatusCast;
use Modules\Quiz\Models\Question;
use Modules\Quiz\Models\QuestionOption;
use Illuminate\Support\Str;
use stdClass;

class QuizService
{
    /**
     * Retrieve paginated quizzes with optional filters.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getQuizzes(?array $select = ['*'], ?array $relations = [], ?array $withCount = [], ?int $tutorId = null, array $filters = [])
    {
        return $this->buildQuizQuery(
            select: $select,
            relations: $relations,
            withCount: $withCount,
            tutorId: $tutorId,
            filters: $filters,
        )
            ->paginate(setting('_general.per_page_opt') ?? 10);
    }

    /**
     * Retrieve all quizzes with optional filters.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllQuizes(?array $select = ['*'], ?array $relations = [], ?array $withCount = [], ?int $tutorId = null, array $filters = []): Collection
    {

        return $this->buildQuizQuery($select, $relations, $withCount, $tutorId, $filters)
            ->get();
    }

    /**
     * Build the base query for quizzes with optional filters.
     *
     * @param array|null $select
     * @param array|null $relations
     * @param int|null $tutorId
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildQuizQuery(?array $select, ?array $relations = [], ?array $withCount = [], ?int $tutorId = null, array $filters = [])
    {

        return Quiz::query()

            ->select($select)

            ->when($tutorId, function ($query) use ($tutorId) {
                return $query->where('tutor_id', $tutorId);
            })

            ->when(isset($filters['statuses']), function ($query) use ($filters) {
                return $query->whereIn('status', $filters['statuses']);
            })

            ->when(isset($filters['title']), function ($query) use ($filters) {
                return $query->where('title', 'like', '%' . $filters['title'] . '%');
            })

            ->with($relations)

            ->withCount($withCount);
    }

    public function submitQuizResult($required_answers = [], $attempted_quiz_id)
    {


        return QuizAttempt::updateOrCreate(
            ['id' => $attempted_quiz_id],
            [
                'correct_answers' => json_encode($required_answers),
                'incorrect_answers' => json_encode($required_answers),
                'earned_marks' => json_encode($required_answers),
                'result' => 'pass'
            ]
        );
    }

    public function getQuizzesList($filters = [])
    {

        $attemp_table = config('quiz.db_prefix') . 'quiz_attempts';
        $quiz_table = config('quiz.db_prefix') . 'quizzes';

        $quizzableTypes = [UserSubjectGroupSubject::class];
        if (isActiveModule('Courses')) {
            $quizzableTypes[] = \Modules\Courses\Models\Course::class;
        }

        return Quiz::query()
            ->select('id', 'quizzable_id', 'quizzable_type', 'tutor_id', 'title', 'status', 'created_at')
            ->where('tutor_id', Auth::user()->id)
            ->selectRaw('(
                SELECT ROUND(SUM(' . $attemp_table . '.correct_answers) / SUM(' . $attemp_table . '.total_questions) * 100, 2)
                FROM ' . $attemp_table . '
                WHERE ' . $attemp_table . '.quiz_id = ' . $quiz_table . '.id
            ) as accuracy_rate')
            ->when(!empty($filters['status']), function ($query) use ($filters) {
                $query->where('status', QuizStatusCast::$statusMap[$filters['status']]);
            })
            ->when(!empty($filters['keyword']), function ($query) use ($filters) {
                $query->where(function ($subQuery) use ($filters) {
                    $subQuery->where('title', 'like', '%' . $filters['keyword'] . '%')
                        ->orWhere('description', 'like', '%' . $filters['keyword'] . '%');
                });
            })
            ->with([
                'settings' => function ($query) {
                    $query->whereIn('meta_key', ['duration', 'duration_type']);
                }
            ])
            ->withWhereHas('quizzable')
            // ->whereHasMorph('quizzable', $quizzableTypes, function ($query, $type) {
            //     // empty
            // })


            ->withCount([
                'quizAttempts' => function ($query) {
                    // $query->where('result', '!=', 'assigned');
                },
                'questions'
            ])

            ->withSum('questions', 'points')

            ->orderBy('id', 'desc')

            ->paginate($filters['per_page'] ?? 10);
    }

    public function quizzsBySlot($slotId)
    {
        return Quiz::with('tutor.profile')->whereJsonContains('user_subject_slots', "$slotId")->get();
    }


    /**
     * Retrieve paginated attempted quizzes with optional filters.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAttemptedQuizzes(?array $select = ['*'], ?array $relations = [], ?int $tutorId = null, array $filters = [], $quizId = null, int $studentId = null, array $withCount = [])
    {
        return $this->buildAttemptedQuizQuery(
            select: $select,
            relations: $relations,
            tutorId: $tutorId,
            filters: $filters,
            quizId: $quizId,
            studentId: $studentId,
            withCount: $withCount
        )
            ->paginate($filters['per_page'] ?? setting('_general.per_page_opt') ?? 10);
    }

    /**
     * Retrieve paginated attempted quizzes with optional filters.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getStudentAttemptedQuiz(string $role = null, int $attemptId, int $userId = null, array $statuses = [])
    {

        return QuizAttempt::query()
            ->when($role == 'tutor', function ($query) use ($userId) {
                return $query->whereHas('quiz', function ($query) use ($userId) {
                    $query->where('tutor_id', $userId);
                });
            })
            ->when($role == 'student', function ($query) use ($userId) {
                return $query->where('student_id', $userId);
            })
            ->when(!empty($statuses), function ($query) use ($statuses) {
                return $query->whereIn('result', $statuses);
            })
            ->with(['quiz.quizzable', 'quiz.settings', 'quiz.questions' => function ($query) use ($attemptId) {
                $query->with(['attemptedQuestions' => function ($q) use ($attemptId) {
                    $q->where('quiz_attempt_id', $attemptId)->limit(1);
                }]);
            }, 'quiz.questions.options'])
            ->find($attemptId);
    }


    public function getQuizAttempt($attemptId, $relations = [])
    {
        return QuizAttempt::with($relations)->find($attemptId);
    }



    /**
     * Build the base query for attempted quizzes with optional filters.
     *
     * @param array|null $select
     * @param array|null $relations
     * @param int|null $userId
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildAttemptedQuizQuery(?array $select, ?array $relations = [], ?int $tutorId = null, array $filters = [], $quizId = null, int $studentId = null, array $withCount = [])
    {
        return QuizAttempt::query()

            ->select($select)

            ->when($tutorId, function ($query) use ($tutorId) {
                return $query->whereHas('quiz', function ($query) use ($tutorId) {
                    $query->where('tutor_id', $tutorId);
                });
            })

            ->when($studentId, function ($query) use ($studentId) {
                return $query->whereHas('student', function ($query) use ($studentId) {
                    $query->where('student_id', $studentId);
                });
            })

            ->when($quizId, function ($query) use ($quizId) {
                return $query->where('quiz_id', $quizId);
            })

            ->when(isset($filters['status']), function ($query) use ($filters) {
                if ($filters['status'] == 'upcoming') {
                    return $query->where('result', '=', QuizAttempt::ASSIGNED);
                } elseif ($filters['status'] == 'attempted') {
                    return $query->where('result', '!=', QuizAttempt::ASSIGNED);
                } else {
                    return $query->where('result', $filters['status']);
                }
            })

            ->when(!empty($filters['sort_by']), function ($query) use ($filters) {
                return $query->orderBy('created_at', $filters['sort_by']);
            })

            ->when(!empty($filters['keyword']), function ($query) use ($filters) {
                return $query->where(function ($q) use ($filters) {
                    if (auth()->user()->role == 'student') {
                        $q->whereHas('quiz', function ($subQuery) use ($filters) {
                            $subQuery->where('title', 'like', "%{$filters['keyword']}%");
                        });
                    } else {
                        $q->whereHas('student.profile', function ($subQuery) use ($filters) {
                            $subQuery->where(function ($subQuery) use ($filters) {
                                $subQuery->where('first_name', 'like', "%{$filters['keyword']}%")
                                    ->orWhere('last_name', 'like', "%{$filters['keyword']}%");
                            })
                                ->orWhereRaw("(CONCAT(first_name, ' ', last_name) like '%{$filters['keyword']}%')");
                        });
                    }
                });
            })
            ->when(isset($filters['quiz_id']), function ($query) use ($filters) {
                return $query->where('quiz_id', $filters['quiz_id']);
            })
            ->with($relations)
            ->withCount($withCount);
    }

    /**
     * Retrieve a quiz by its ID.
     * @param arrray $select
     * @param int $quizId
     * @param int|null $tutorId
     * @param array|null $relations
     * @return \Modules\Quiz\Models\Quiz
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getQuiz(array $select = ['*'], int $quizId, int $tutorId = null, ?array $relations = [], int $studentId = null, array $withCount = [], array $withSum = []): ?Quiz
    {
        return Quiz::select($select)
            ->with($relations)

            ->when(!empty($tutorId), function ($query) use ($tutorId) {
                return $query->whereHas('tutor', function ($query) use ($tutorId) {
                    $query->where('tutor_id', $tutorId);
                });
            })

            ->when(!empty($studentId), function ($query) use ($studentId) {
                return $query->withWhereHas('quizAttempts', function ($query) use ($studentId) {
                    $query->where('student_id', $studentId);
                });
            })

            ->withCount($withCount)
            ->withCount('questions')

            ->when(!empty($withSum), function ($query) use ($withSum) {
                foreach ($withSum as $relation => $column) {
                    $query->withSum($relation, $column);
                }
            })
            ->withSum('questions', 'points')

            ->find($quizId);
    }

    /**
     * Retrieve a quiz by its ID.
     * @param arrray $select
     * @param int $quizId
     * @param int|null $tutorId
     * @param array|null $relations
     * @return \Modules\Quiz\Models\Quiz
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getAttemptedQuiz(
        int $attemptId,
        ?array $select = ['*'],
        int $tutorId = null,
        ?array $relations = [],
        int $studentId = null,
        array $withCount = [],
        array $withSum = [],
        array $filters = []
    ): ?QuizAttempt {

        return QuizAttempt::select($select)
            ->with($relations)

            ->when(!empty($tutorId), function ($query) use ($tutorId) {
                return $query->whereHas('tutor', function ($query) use ($tutorId) {
                    $query->where('tutor_id', $tutorId);
                });
            })

            ->when(!empty($studentId), function ($query) use ($studentId) {
                return $query->whereHas('student', function ($query) use ($studentId) {
                    $query->where('student_id', $studentId);
                });
            })

            ->when(isset($filters['status']), function ($query) use ($filters) {
                $query->where('result', $filters['status']);
            })
            ->withCount($withCount)
            ->when(!empty($withSum), function ($query) use ($withSum) {
                foreach ($withSum as $relation => $column) {
                    $query->withSum($relation, $column);
                }
            })
            ->withSum('attemptedQuestions', 'marks_awarded')
            ->find($attemptId);
    }

    /**
     * Create a new quiz along with its questions and options.
     *
     * @param array $quizData
     * @return \App\Models\Quiz
     *
     * @throws \Exception
     */
    public function createQuiz(array $quizData): Quiz|false
    {
        try {
            DB::beginTransaction();

            // Create the quiz
            $quiz = Quiz::create([
                'tutor_id'              => Auth::id(),
                'quizzable_type'        => $quizData['quizzable_type'],
                'quizzable_id'          => $quizData['quizzable_id'],
                'user_subject_slots'    => $quizData['user_subject_slots'],
                'title'                 => $quizData['title'],
                'description'           => $quizData['description'] ?? null,
                'status'                => $quizData['status'] ?? 'draft',
            ]);

            $quizSetting = [
                'duration'              => '02:30',
                'duration_type'         => 'hours',
                'hide_quiz_timer'       => 0,
                'attempts_allowed'      => 1,
                'passing_grade'         => 50,
                'question_order'        => 'asc',
                'hide_question_number'  => 0,
                'short_ans_limit'       => 500,
                'max_ans_limit'         => 5000,
                'auto_result_generate'  => 0,
            ];

            $quizId = $quiz?->id ?? null;
            $quizSettings = array_map(function ($metaKey, $metaValue) use ($quizId) {
                return [
                    'quiz_id' => $quizId,
                    'meta_key' => $metaKey,
                    'meta_value' => $metaValue,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, array_keys($quizSetting), $quizSetting);

            QuizSetting::insert($quizSettings);

            DB::commit();

            return $quiz;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            DB::rollBack();

            return false;
        }
    }
    /**
     * Update a quiz by its ID.
     *
     * @param int $quizId
     * @param array $quizData
     * @return \Modules\Quiz\Models\Quiz|null
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function updateQuiz(int $quizId, array $quizData): Quiz|null
    {
        $quiz = Quiz::find($quizId);
        if (!empty($quiz)) {
            $quiz->update([
                'quizzable_type'        => $quizData['quizzable_type'],
                'quizzable_id'          => $quizData['quizzable_id'],
                'user_subject_slots'    => $quizData['user_subject_slots'],
                'title'                 => $quizData['title'],
                'description'           => $quizData['description'] ?? null,
                'status'                => $quizData['status'] ?? 'draft',
            ]);
        }

        return $quiz;
    }

    /**
     * Add or update quiz settings.
     *
     * @param int $quizId
     * @param array $settings
     * @return \App\Models\Quiz
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function addQuizSettings(int $quizId, array $settings): bool
    {
        try {
            foreach ($settings as $metaKey => $metaValue) {
                QuizSetting::updateOrCreate(
                    ['quiz_id' => $quizId, 'meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Retrieve quiz settings.
     *
     * @param int $quizId
     * @return array
     */
    public function getQuizSettings(int $quizId): array
    {
        $settings = QuizSetting::where('quiz_id', $quizId)
            ->pluck('meta_value', 'meta_key')
            ->toArray();

        return $settings;
    }

    public function getQuizQuestionType($quizId)
    {
        $questionType = array_values(Question::where('quiz_id', $quizId)->pluck('type')->toArray());
        return $questionType;
    }

    /**
     * Publish a quiz.
     *
     * @param int $quizId
     * @return \App\Models\Quiz
     *
     * @throws \Exception
     */
    public function publishQuiz(int $quizId): Quiz
    {
        $quiz = Quiz::findOrFail($quizId);

        if ($quiz->status !== 'draft') {
            throw ValidationException::withMessages([
                'status' => 'Only quizzes in draft status can be published.',
            ]);
        }

        $quiz->status = 'published';
        $quiz->save();

        return $quiz;
    }

    /**
     * Archive a quiz.
     *
     * @param int $quizId
     * @return \App\Models\Quiz
     *
     * @throws \Exception
     */
    public function archiveQuiz(int $quizId): Quiz
    {
        $quiz = Quiz::findOrFail($quizId);

        if ($quiz->status === 'archived') {
            throw ValidationException::withMessages([
                'status' => 'Quiz is already archived.',
            ]);
        }

        $quiz->status = 'archived';
        $quiz->save();

        return $quiz;
    }

    /**
     * Revert a quiz to draft status.
     *
     * @param int $quizId
     * @return \App\Models\Quiz
     *
     * @throws \Exception
     */
    public function revertQuizToDraft(int $quizId): Quiz
    {
        $quiz = Quiz::findOrFail($quizId);

        if ($quiz->status === 'draft') {
            throw ValidationException::withMessages([
                'status' => 'Quiz is already in draft status.',
            ]);
        }

        $quiz->status = 'draft';
        $quiz->save();

        return $quiz;
    }

    /**
     * Create Quiz with AI
     * @param array $quizData
     * @return array
     */

    public function createAiQuiz($quizData): array
    {
        try {
            if (!empty(setting('_quiz.generate_quiz_prompt'))) {
                DB::beginTransaction();
                $inputQuizData = $quizData;
                $promptReplaceData = [
                    'quiz_brief'          => $quizData['description'],
                    'question_types'      => '',
                    'quizzable_title'     => ''
                ];
                unset($quizData['user_subject_slots']);
                unset($inputQuizData['question_types']);
                $quizzableInfo = $this->getQuizzable($quizData['quizzable_type'], $quizData['quizzable_id']);
                if ($quizzableInfo instanceof UserSubjectGroupSubject) {
                    $promptReplaceData['quizzable_title'] = $quizzableInfo?->subject?->name;
                } else {
                    $promptReplaceData['quizzable_title'] = $quizzableInfo->title;
                }
                foreach ($quizData['question_types'] as $questionType => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $promptReplaceData['question_types'] .= __('quiz::quiz.' . $questionType) . ' ' . $value . ', ';
                }
                $promptReplaceData['question_types'] = rtrim($promptReplaceData['question_types'], ', ');
                $prompt = $this->replacePromptVariables(setting('_quiz.generate_quiz_prompt'), $promptReplaceData);
                $aiResponse = $this->makeAiRequest($prompt);
                if (empty($aiResponse['success'])) {
                    return $aiResponse;
                }
                $cleanedAiResponse =  stripcslashes(preg_replace('/^```json|```$/m', '', $aiResponse['response']));
                $quizAiData = json_decode($cleanedAiResponse);
                $quiz = $this->createQuizWithQuestions($inputQuizData, $quizAiData);
                DB::commit();
                return ['success' => true, 'message' => __('quiz::quiz.quiz_created_successfully'), 'quiz' => $quiz];
            } else {
                return ['success' => false, 'message' => __('quiz::quiz.missing_prompt')];
            }
        } catch (\Exception $ex) {
            Log::info($ex);
            DB::rollBack();
            return ['success' => false, 'message' => $ex->getMessage()];
        }
    }

    /**
     * Make API Call to openAi
     * @param string $prompt
     * @param integer $maxTokens
     * @param string $model
     */
    protected function makeAiRequest(string $prompt, string $model = 'gpt-4o-mini'): array
    {
        try {

            $params = [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ];

            $response = Http::timeout(0)->withHeaders([
                'Authorization' => 'Bearer ' . setting('_api.openai_api_key'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', $params);

            if ($response->successful()) {
                $aiResponseAll = $response->json();
                $aiResponse = $aiResponseAll['choices'][0]['message']['content'];
                return [
                    'success' => true,
                    'response' => $aiResponse
                ];
            } else {
                return ['success' => false, 'message' => $response->json()['error']['message'] ?? __('general.something_went_wrong')];
            }
        } catch (\Exception $ex) {
            return ['success' => false, 'message' => $ex->getMessage()];
        }
    }

    /**
     * Replce wildcards for AI Prompt
     * @param string $prompt
     * @param array $variables
     * @return string $prompt
     */

    protected function replacePromptVariables($prompt, $variables): string
    {
        foreach ($variables as $key => $value) {
            $prompt = str_replace('{' . $key . '}', $value, $prompt);
        }
        return $prompt;
    }

    /**
     * Get Quizzable table Record
     * @param string $quizzableType
     * @param int $quizzableId
     * @return mixed
     */

    protected function getQuizzable($quizzableType, $quizzableId): mixed
    {
        $tableRecord = app($quizzableType)::find($quizzableId);
        if ($tableRecord) {
            return $tableRecord;
        }
        return [];
    }

    /**
     * Create a new quiz along with its questions and options.
     *
     * @param array $quizData
     * @param stdClass $aiResponse
     * @return \Module\Quiz\Models\Quiz
     *
     * @throws \Exception
     */
    public function createQuizWithQuestions(array $quizData, stdClass $aiResponse): Quiz
    {
        // Create the quiz
        $quiz = Quiz::create([
            'tutor_id'              => Auth::id(),
            'quizzable_type'        => $quizData['quizzable_type'],
            'quizzable_id'          => $quizData['quizzable_id'],
            'user_subject_slots'    => $quizData['user_subject_slots'],
            'title'                 => $aiResponse->title,
            'description'           => $aiResponse->description,
            'status'                => $quizData['status'] ?? 'draft',
        ]);

        $quizSetting = [
            'duration'              => '02:30',
            'duration_type'         => 'hours',
            'hide_quiz_timer'       => 0,
            'attempts_allowed'      => 1,
            'passing_grade'         => 50,
            'question_order'        => 'asc',
            'hide_question_number'  => 0,
            'short_ans_limit'       => 500,
            'max_ans_limit'         => 100,
            'auto_result_generate'  => 0,
        ];

        $quizSettings = array_map(function ($metaKey, $metaValue) use ($quiz) {
            return [
                'quiz_id' => $quiz->id,
                'meta_key' => $metaKey,
                'meta_value' => $metaValue,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, array_keys($quizSetting), $quizSetting);

        QuizSetting::insert($quizSettings);
        $questionsData = $aiResponse->questions;

        foreach ($questionsData as $position => $aiQuestion) {
            $question = Question::create(
                [
                    'quiz_id'             => $quiz->id,
                    'type'                => $aiQuestion->type,
                    'title'               => $aiQuestion->type == Question::TYPE_FILL_IN_BLANKS ? preg_replace('/_{2,}/', '[Blank]', $aiQuestion->question_title) : $aiQuestion->question_title,
                    'description'         => $aiQuestion->question_description,
                    'settings'            => [
                        'answer_required'     => true,
                        'random_choice'       => false,
                        'display_points'      => true,
                        'character_limit'     => $aiQuestion->character_limit ?? null,
                    ],
                    'points'              => 1,
                    'position'            => $position,
                ]
            );

            if (!empty($aiQuestion->options)) {
                $optionOrder = 1;
                foreach ($aiQuestion->options as $option => $text) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $text,
                        'position'    => $optionOrder,
                        'is_correct'  => $option == $aiQuestion->correct_answer,
                    ]);
                    $optionOrder++;
                }
            }

            if ($aiQuestion->type == Question::TYPE_TRUE_FALSE) {
                $optionOrder = 1;
                foreach (['True', 'False'] as $option) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option,
                        'position'    => $optionOrder,
                        'is_correct'  => $option == $aiQuestion->correct_answer,
                    ]);
                    $optionOrder++;
                }
            }

            if ($aiQuestion->type == Question::TYPE_FILL_IN_BLANKS) {
                $optionOrder = 1;
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $aiQuestion->correct_answer,
                    'position'    => $optionOrder,
                    'is_correct'  => true,
                ]);
                $optionOrder++;
            }
        }
        return $quiz;
    }

    /**
     * Duplicate a quiz with all its questions, options, and settings
     *
     * @param int $quizId
     * @return Quiz
     */
    public function duplicateQuiz(int $quizId)
    {
        $originalQuiz = Quiz::with([
            'questions.options',
            'questions.media',
            'settings'
        ])->findOrFail($quizId);

        $newQuiz = $originalQuiz->replicate()->fill([
            'created_at'    => now(),
            'updated_at'    => now(),
            'title'         => $originalQuiz->title . ' (Copy)',
            'status'        => Quiz::STATUS_DRAFT
        ]);

        $newQuiz->save();

        if ($originalQuiz->questions->isNotEmpty()) {
            foreach ($originalQuiz->questions as $question) {
                $newQuestion = $question->replicate()->fill([
                    'created_at'    => now(),
                    'updated_at'    => now(),
                    'quiz_id'       => $newQuiz->id
                ]);

                $newQuestion->save();

                if (!empty($question->media)) {
                    foreach ($question->media as $media) {
                        $newMedia = $media->replicate()->fill([
                            'created_at'    => now(),
                            'updated_at'    => now(),
                            'mediable_id'   => $newQuestion->id
                        ]);
                        $newMedia->save();
                    }
                }

                foreach ($question->options as $option) {
                    $newOption = $option->replicate()->fill([
                        'question_id'       => $newQuestion->id,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);
                    $newOption->save();
                }
            }
        }

        if ($originalQuiz->settings->isNotEmpty()) {
            foreach ($originalQuiz->settings as $setting) {
                $newSetting = $setting->replicate()->fill([
                    'quiz_id'              => $newQuiz->id,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]);
                $newSetting->save();
            }
        }

        return $newQuiz;
    }

    public function archivedQuiz($id, $status)
    {
        $quiz = Quiz::where('id', $id)->first();
        if (!empty($quiz)) {
            $quiz->status = $status;
            $quiz->save();
            return true;
        }
        return false;
    }

    public function getQuizTile($id)
    {
        $quiz = Quiz::where('id', $id)->select('id', 'title')->first();
        return $quiz;
    }

    public function getQuizStatus($id)
    {
        return Quiz::where('id', $id)->value('status');
    }

    public function getAssignedQuiz(int $quizId, int $studentId)
    {
        return QuizAttempt::where('quiz_id', $quizId)->where('student_id', $studentId)->exists();
    }

    public function assignQuiz(int $quizId, array $studentIds)
    {
        if (empty($quizId) || empty($studentIds)) {
            return false;
        }

        $quiz = Quiz::with('questions', 'tutor.profile')->whereStatus(Quiz::PUBLISHED)->find($quizId);

        if (empty($quiz)) {
            return false;
        }

        foreach ($studentIds as $studentId) {

            $quizAttempt = QuizAttempt::where('quiz_id', $quiz->id)->where('student_id', $studentId)->first();
            if (!empty($quizAttempt)) {
                continue;
            }

            $student = User::find($studentId);
            if (!empty($student)) {
                $detail = QuizAttempt::create(
                    [
                        'quiz_id'           => $quiz->id,
                        'student_id'        => $student->id,
                        'total_questions'   => $quiz->questions->count(),
                        'total_marks'       => $quiz->questions->sum('points'),
                        'result'            => QuizAttempt::RESULT_ASSIGNED,
                    ]
                );
            }
            return $detail;
        }
    }

    public function  startQuiz($id)
    {
        $quiz = QuizAttempt::where('quiz_id', $id)->first();
        if (!empty($quiz)) {
            $quiz->started_at = now();
            $quiz->save();
            return true;
        }
        return false;
    }

    public function getAttemptedId($quizId)
    {
        $quiz = QuizAttempt::where('quiz_id', $quizId)->first();
        if (!empty($quiz)) {
            return $quiz->id;
        }
        return false;
    }

    public function updateActiveQuestion($quizAttempt, $activeQuestionId, $started_at = null)
    {
        $quizAttempt->active_question_id = $activeQuestionId;
        if (!empty($started_at)) {
            $quizAttempt->started_at = $started_at;
        }
        $quizAttempt->save();
    }

    public function autoAssignQuiz($quizable, $studentId)
    {
        $student = User::with('profile')->find($studentId);
        $isAssigned = false;
        if (isActiveModule('Quiz')) {
            $quizzes = Quiz::where('quizzable_id', $quizable->id)->where('quizzable_type', get_class($quizable))->get();
            if (!empty($quizzes)) {
                foreach ($quizzes as $quiz) {
                    $isAlreadyAssigned = $this->getAssignedQuiz($quiz->id, $studentId);

                    if (!$isAlreadyAssigned && $quiz->status == 'published') {
                        $isAssigned = true;
                        $quizDetail = $this->assignQuiz($quiz->id, [$studentId]);

                        $emailData = [
                            'quizTitle'       => $quiz->title,
                            'studentName'     => $student?->profile?->full_name,
                            'tutorName'       => $quiz->tutor?->profile?->full_name,
                            'quizUrl'         => route('quiz.student.quiz-details', ['attemptId' => $quizDetail?->id])
                        ];

                        $notifyData = [
                            'quizTitle'         => $quiz->title,
                            'studentName'       => $student?->profile?->full_name,
                            'tutorName'         => $quiz->tutor?->profile?->full_name,
                            'assignedQuizUrl'   => route('quiz.student.quizzes')
                        ];

                        dispatch(new \App\Jobs\SendNotificationJob('assignedQuiz', $student, $emailData));
                        dispatch(new \App\Jobs\SendDbNotificationJob('assignedquiz', $student, $notifyData));
                    }
                }
            }
        }
        return $isAssigned;
    }
}
