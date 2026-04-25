<?php

namespace Modules\Quiz\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Quiz\Models\AttemptedQuestion;
use Modules\Quiz\Models\Question;
use Modules\Quiz\Models\QuestionOption;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Models\Media;


class QuestionService
{

    /**
     * Get all questions for the quiz.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getQuestions(int $quizId)
    {
        return Question::whereQuizId($quizId)->orderBy('position')->get();
    }


    /**
     * Get all questions for the quiz.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllQuestions(int $quizId, $questionType = null, $keyword = null, $relations = [])
    {
        $question = Question::whereQuizId($quizId)
            ->with($relations)
            ->when($questionType, function ($q) use ($questionType) {
                $q->where('type', $questionType);
            })
            ->with('options', function ($q) {
                $q->orderBy('position');
            })
            ->when($keyword, function ($q) use ($keyword) {
                $q->where('title', 'like', "%$keyword%");
            })
            ->orderBy('position')->get();
        return $question;
    }


    /**
     * Get all options for a given question.
     *
     * @param int $questionId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getQuestionOptions(int $questionId)
    {
        $options = QuestionOption::whereQuestionId($questionId)->with('image')->get();
        if ($options->count() > 0) {
            return $options;
        }
        return [];
    }

    /**
     * Get all questions for the quiz.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getQuestion(int $questionId)
    {
        return Question::whereId($questionId)->with(['options', 'media'])->first();
    }

    /**
     * Create a question with its options (if applicable) for a given quiz.
     *
     * @param int $quizId
     * @param array $questionData
     * @return \App\Models\Question
     *
     * @throws \Exception
     */
    public function createQuestion(int $quizId, array $questionData, ?int $questionId = null): Question
    {
        $maxPosition = Question::where('quiz_id', $quizId)?->max('position') ?? 0;
        $question = Question::updateOrCreate(
            ['id' => $questionId],
            [
                'quiz_id'             => $quizId,
                'type'                => $questionData['type'],
                'title'               => $questionData['title'],
                'description'        => $questionData['description'] ?? null,
                'points'              => $questionData['points'] ?? 1,
                'position'            => $questionId ? Question::find($questionId)?->position : $maxPosition + 1,
                'settings'            => $questionData['settings'],
            ]
        );

        if (!empty($questionData['options']) && is_array($questionData['options'])) {
            $existingOptions = QuestionOption::where('question_id', $question->id)->get();
            $updatedOptionIds = [];

            foreach ($questionData['options'] as $key => $optionData) {
                if (!empty($optionData['id'])) {
                    // Update existing option
                    $option = $existingOptions->firstWhere('id', $optionData['id']);
                    if ($option) {
                        $option->update([
                            'option_text' => $optionData['option_text'],
                            'is_correct'  => $optionData['is_correct'] ?? false,
                            'position'    => $optionData['position'] ?? $key,
                        ]);
                        $updatedOptionIds[] = $option->id;
                    }
                } else {
                    // Create new option
                    $newOption = new QuestionOption([
                        'question_id' => $question->id,
                        'option_text' => $optionData['option_text'],
                        'is_correct'  => $optionData['is_correct'] ?? false,
                        'position'    => $optionData['position'] ?? $key,
                    ]);
                    $newOption->save();
                    $updatedOptionIds[] = $newOption->id;
                }
            }

            QuestionOption::where('question_id', $question->id)
                ->whereNotIn('id', $updatedOptionIds)
                ->delete();
        }

        return $question;
    }


    public function createQuestionMedia($data)
    {
        Media::updateOrCreate(
            [
                'mediable_id'   => $data['mediable_id'],
                'mediable_type' => $data['mediable_type']
            ],
            $data
        );
    }

    public function deleteQuestionMedia($question)
    {
        $question->thumbnail()->delete();
    }

    /**
     * Update a question and its options.
     *
     * @param int $questionId
     * @param array $data
     * @return \App\Models\Question
     *
     * @throws \Exception
     */
    public function updateQuestion(int $questionId, array $data): Question
    {
        $question = Question::findOrFail($questionId);

        // Update question fields
        $question->update([
            'question_text' => $data['question_text'] ?? $question->question_text,
            'answer_required' => $data['answer_required'] ?? $question->answer_required,
            'random_choice' => $data['random_choice'] ?? $question->random_choice,
            'points' => $data['points'] ?? $question->points,
            'display_points' => $data['display_points'] ?? $question->display_points,
            'character_limit' => $data['character_limit'] ?? $question->character_limit,
            'correct_answer' => $data['correct_answer'] ?? $question->correct_answer,
        ]);

        // If MCQ, update options
        if ($question->type === 'mcq' && isset($data['options'])) {
            // Ensure at least two options
            if (count($data['options']) < 2) {
                throw ValidationException::withMessages([
                    'options' => 'At least two options are required for MCQ questions.',
                ]);
            }

            // Update existing options or create new ones
            foreach ($data['options'] as $optionData) {
                if (isset($optionData['id'])) {
                    // Update existing option
                    $option = QuestionOption::findOrFail($optionData['id']);
                    $option->update([
                        'option_text' => $optionData['option_text'],
                    ]);
                } else {
                    // Create new option
                    $question->options()->create([
                        'option_text' => $optionData['option_text'],
                    ]);
                }
            }

            // Optionally, handle deletion of removed options
            // Implement logic as needed
        }

        return $question;
    }

    /**
     * Delete a question and its related options.
     *
     * @param int $questionId
     * @return void
     *
     * @throws \Exception
     */
    public function deleteQuestion(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $question->delete();
    }

    public function createQuestionAttempt($questionData)
    {
        $quizAttempted = AttemptedQuestion::updateOrCreate([
            'quiz_attempt_id'       => $questionData['quiz_attempt_id'],
            'question_id'           => $questionData['question_id'],
        ], $questionData);

        return $quizAttempted;
    }


    public function addQuestionImages($questionId, $images, $correctAnswer)
    {
        if (!empty($images)) {
            $existingOptions = QuestionOption::where('question_id', $questionId)->get();
            foreach ($existingOptions as $option) {
                $option->image()->delete();
            }
            QuestionOption::where('question_id', $questionId)->delete();

            foreach ($images as $key => $image) {
                if (!empty($image['option_image']) && $image['option_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imageName = $image['option_image']->getClientOriginalName();
                    $imagePath = $image['option_image']->storeAs('quiz/question/options', $imageName, getStorageDisk());
                } else {
                    $imagePath = $image['option_image'];
                }

                $questionOption = QuestionOption::create([
                    'question_id' => $questionId,
                    'option_text' => null,
                    'is_correct'  => $key == $correctAnswer,
                ]);

                if ($questionOption) {

                    $questionOption->image()->create([
                        'mediable_id'   => $questionOption->id,
                        'mediable_type' => QuestionOption::class,
                        'type'          => 'image',
                        'path'          => $imagePath,
                    ]);
                }
            }
        }
    }

    public function udpateQuestionPosition($quizId, $list)
    {
        $isUpdate = false;
        $questions = Question::where('quiz_id', $quizId)->get();
        if ($questions->isNotEmpty()) {
            foreach ($list as $item) {
                $question = $questions->firstWhere('id', $item['value']);
                if ($question) {
                    $isUpdate = $question->update([
                        'position' => $item['order']
                    ]);
                }
            }
        }
        return $isUpdate;
    }
}
