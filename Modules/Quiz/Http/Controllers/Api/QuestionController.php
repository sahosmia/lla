<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Modules\Quiz\Http\Requests\QuestionTypes\OpenEndedEssayRequest;
use Modules\Quiz\Http\Requests\QuestionTypes\FillInBlanksRequest;
use Modules\Quiz\Http\Requests\QuestionTypes\ShortAnswerRequest;
use Modules\Quiz\Http\Requests\QuestionTypes\TrueFalseRequest;
use Modules\Quiz\Http\Requests\QuestionTypes\McqRequest;
use Modules\Quiz\Http\Resources\QuestionResource;
use Symfony\Component\HttpFoundation\Response;
use Modules\Quiz\Services\QuestionService;
use Modules\Quiz\Services\QuizService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Modules\Quiz\Models\Question;
use Modules\Quiz\Models\Quiz;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class QuestionController extends Controller
{
    use ApiResponser;
    protected $quizService;
    protected $questionService;

    public function __construct()
    {
        $this->quizService      = new QuizService();
        $this->questionService  = new QuestionService();
    }

    public function getQuestions(Request $request)
    {
        if (!$request->id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $quiz = $this->quizService->getQuiz(['*'], $request->id);

        if (!$quiz) {
            return $this->error(message: __('quiz::quiz.quiz_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if (Auth::user()->id != $quiz->tutor_id) {
            return $this->error(message: __('quiz::quiz.not_authorized'), code: Response::HTTP_FORBIDDEN);
        }

        try {

            $questions = $this->questionService->getAllQuestions($request->id, $request->question_type, $request->keyword, relations: ['quiz.settings']);

            if ($questions) {
                return $this->success(data: QuestionResource::collection($questions), message: __('quiz::quiz.question_list_retrieved_successfully'), code: Response::HTTP_OK);
            } else {
                return $this->error(message: __('quiz::quiz.question_list_not_found'), code: Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {

            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteQuestion(Request $request)
    {
        $response = isDemoSite();

        if ($response) {
            return $this->error(message: __('general.demosite_res_txt'), code: Response::HTTP_BAD_REQUEST);
        }

        if (!$request->id) {
            return $this->error(message: __('quiz::quiz.id_required'), code: Response::HTTP_BAD_REQUEST);
        }

        $question = $this->questionService->getQuestion($request->id);

        if (!$question) {
            return $this->error(message: __('quiz::quiz.question_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        $quiz = $this->quizService->getQuiz(['*'], $question->quiz_id);

        if (!$quiz) {
            return $this->error(message: __('quiz::quiz.quiz_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if ($quiz->status == Quiz::STATUS_ARCHIVED || $quiz->status == Quiz::STATUS_PUBLISHED) {
            return $this->error(message: __('quiz::quiz.question_cannot_be_deleted_because_quiz_is', ['status' => $quiz->status]), code: Response::HTTP_BAD_REQUEST);
        }

        if (Auth::user()->id != $quiz->tutor_id) {
            return $this->error(message: __('quiz::quiz.not_authorized_to_delete_question'), code: Response::HTTP_FORBIDDEN);
        }

        try {

            $this->questionService->deleteQuestion($request->id);
            return $this->success(message: __('quiz::quiz.question_deleted_successfully'), code: Response::HTTP_OK);
        } catch (\Exception $e) {

            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    public function createOrUpdateTrueFalse(TrueFalseRequest $request)
    {
        return $this->handleCreateOrUpdateQuestion($request, $request->questionType ?? 'true_false');
    }

    public function createOrUpdateMcq(McqRequest $request)
    {
        return $this->handleCreateOrUpdateQuestion($request, $request->questionType ?? 'mcq');
    }

    public function createOrUpdateFillInTheBlank(FillInBlanksRequest $request)
    {
        return $this->handleCreateOrUpdateQuestion($request, $request->questionType ?? 'fill_in_blanks');
    }

    public function createOrUpdateShortAnswer(ShortAnswerRequest $request)
    {
        return $this->handleCreateOrUpdateQuestion($request, $request->questionType ?? 'short_answer');
    }

    public function createOrUpdateOpenEndedEssay(OpenEndedEssayRequest $request)
    {
        return $this->handleCreateOrUpdateQuestion($request, $request->questionType ?? 'open_ended_essay');
    }

    private function handleCreateOrUpdateQuestion($request, string $type)
    {
        if (isDemoSite()) {
            return $this->error(message: __('general.demosite_res_txt'), code: Response::HTTP_BAD_REQUEST);
        }

        $quiz = $this->quizService->getQuiz(['*'], $request->quiz_id);

        if (!$request->quiz_id || !$quiz) {
            return $this->error(message: __('quiz::quiz.quiz_not_found_or_id_missing'), code: Response::HTTP_BAD_REQUEST);
        }

        if (Auth::id() !== $quiz->tutor_id) {
            return $this->error(message: __('quiz::quiz.unauthorized_action'), code: Response::HTTP_FORBIDDEN);
        }

        if (in_array($quiz->status, [Quiz::STATUS_ARCHIVED, Quiz::STATUS_PUBLISHED])) {
            return $this->error(message: __('quiz::quiz.cannot_modify_questions_for_a', ['status' => $quiz->status]), code: Response::HTTP_BAD_REQUEST);
        }

        $question = null;

        if ($request->question_id) {
            $question = $this->questionService->getQuestion($request->question_id);

            if (!$question || $question->quiz_id != $request->quiz_id) {
                return $this->error(message: __('quiz::quiz.invalid_or_unauthorized_question_update'), code: Response::HTTP_FORBIDDEN);
            }
        }

        $points = $request->points ?? 1;

        if (!ctype_digit((string)$points) || (int)$points <= 0 || $points > 100) {
            return $this->error(message: __('quiz::quiz.points_must_be_a_whole_number_between_1_and_100'), code: Response::HTTP_BAD_REQUEST);
        }

        if ($type === Question::TYPE_FILL_IN_BLANKS) {
            $blankCount = substr_count(strtoupper($request->question_title), '[BLANK]');
            $blanksProvided = is_array($request->blanks) ? count($request->blanks) : 0;

            if ($blankCount !== $blanksProvided) {
                return $this->error(
                    message: __('quiz::quiz.blank_count_mismatch'),
                    code: Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }

        $options = $this->buildOptions($request, $type);
        if ($type == Question::TYPE_MCQ || $type == Question::TYPE_FILL_IN_BLANKS || $type == Question::TYPE_TRUE_FALSE) {
            if (empty($options)) {
                return $this->error(message: __('quiz::quiz.no_valid_options_provided'), code: Response::HTTP_BAD_REQUEST);
            }
        }

        $settings = [
            'quiz_id'       => $request->quiz_id,
            'title'         => $request->question_title,
            'description'   => $request->question_text ?? null,
            'points'        => $points,
            'type'          => $request->questionType ?? $type,
            'options'       => $options,
            'settings'      => [
                'answer_required' => boolval($request->answer_required),
                'random_choice'   => boolval($request->random_choice),
            ]
        ];

        if ($type == Question::TYPE_MCQ) {
            $settings['settings']['display_points'] = $request->display_points ?? true;
        }

        $allowedExtensions = explode(',', setting('_general.allowed_image_extensions') ?? 'jpg,png');

        try {

            $questionService = new QuestionService();
            $question        = $questionService->createQuestion($request->quiz_id, $settings, $request->question_id);
            $media           = setQuizMedia($request->questionMedia, 'image', $allowedExtensions);

            $questionService->deleteQuestionMedia($question);

            if (!empty($media['path'])) {
                $questionService->createQuestionMedia([
                    'mediable_id'   => $question->id,
                    'mediable_type' => Question::class,
                    'type'          => $media['type'],
                    'path'          => $media['path'],
                ]);
            }

            $action = $request->question_id ? 'updated' : 'created';

            $label = match ($type) {
                Question::TYPE_MCQ              => __('quiz::quiz.mcq'),
                Question::TYPE_FILL_IN_BLANKS   => __('quiz::quiz.fill_in_the_blanks'),
                Question::TYPE_SHORT_ANSWER     => __('quiz::quiz.short_answer'),
                Question::TYPE_OPEN_ENDED_ESSAY => __('quiz::quiz.open_ended_essay'),
                Question::TYPE_TRUE_FALSE       => __('quiz::quiz.true_false'),
                default => __('quiz::quiz.true_false'),
            };

            return $this->success(message: __('quiz::quiz.question_label_question_action_successfully', ['label' => $label, 'action' => $action]), code: Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error(message: $e->getMessage(), code: Response::HTTP_BAD_REQUEST);
        }
    }

    private function buildOptions($request, string $type): array
    {
        if ($type === Question::TYPE_TRUE_FALSE) {
            return [
                ['option_text' => 'True', 'is_correct' => $request->correct_answer == "true"],
                ['option_text' => 'False', 'is_correct' => $request->correct_answer == "false"],
            ];
        }

        if ($type === Question::TYPE_MCQ && is_array($request->mcqs)) {
            return array_map(function ($key, $option) use ($request) {
                return [
                    'option_text' => $option['option_text'] ?? '',
                    'position'    => $option['position'] ?? $key,
                    'is_correct'  => $key == $request->correct_answer,
                ];
            }, array_keys($request->mcqs), $request->mcqs);
        }

        if ($type === Question::TYPE_FILL_IN_BLANKS && is_array($request->blanks)) {
            return array_map(function ($key, $blank) {
                return [
                    'option_text'   => $blank['option_text'],
                    'is_correct'    => 1,
                ];
            }, array_keys($request->blanks), $request->blanks);
        }

        return [];
    }
}
