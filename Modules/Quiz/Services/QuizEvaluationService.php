<?php

namespace App\Services;

use App\Models\AttemptedAnswer;
use Modules\Quiz\Models\AttemptedAnswre;

class QuizEvaluationService
{
    /**
     * Evaluate an answer based on its question type.
     *
     * @param AttemptedAnswre $answer
     * @return void
     */
    public function evaluate(AttemptedAnswre $answer)
    {
        $question = $answer->question;
        $correctAnswer = $question->correct_answer;
        $studentAnswer = $answer->answer;

        switch ($question->type) {
            case 'mcq':
                $this->evaluateMCQ($answer, $correctAnswer, $studentAnswer);
                break;

            case 'fill_in_blank':
                $this->evaluateFillInBlank($answer, $correctAnswer, $studentAnswer);
                break;

            case 'true_false':
                $this->evaluateTrueFalse($answer, $correctAnswer, $studentAnswer);
                break;

            default:
                // Handle other types or throw an exception
                break;
        }
    }

    protected function evaluateMCQ(AttemptedAnswre $answer, $correctAnswer, $studentAnswer)
    {
        $correctOptionIds = $correctAnswer['option_ids'] ?? [];
        $selectedOptionIds = $studentAnswer['selected_option_ids'] ?? [];

        sort($correctOptionIds);
        sort($selectedOptionIds);

        $isCorrect = $correctOptionIds === $selectedOptionIds;
        $marksAwarded = $isCorrect ? $answer->question->points : 0;

        $this->updateAnswer($answer, $isCorrect, $marksAwarded);
    }

    protected function evaluateFillInBlank(AttemptedAnswre $answer, $correctAnswer, $studentAnswer)
    {
        $acceptableAnswers = array_map('strtolower', $correctAnswer['values'] ?? []);
        $userAnswers = array_map('strtolower', $studentAnswer['answers'] ?? []);

        $isCorrect = $userAnswers === $acceptableAnswers;
        $marksAwarded = $isCorrect ? $answer->question->points : 0;

        $this->updateAnswer($answer, $isCorrect, $marksAwarded);
    }

    protected function evaluateTrueFalse(AttemptedAnswre $answer, $correctAnswer, $studentAnswer)
    {
        $correctValue = $correctAnswer['value'] ?? false;
        $userValue = $studentAnswer['value'] ?? false;

        $isCorrect = $correctValue === $userValue;
        $marksAwarded = $isCorrect ? $answer->question->points : 0;

        $this->updateAnswer($answer, $isCorrect, $marksAwarded);
    }

    protected function updateAnswer(AttemptedAnswre $answer, $isCorrect, $marksAwarded)
    {
        $answer->is_correct = $isCorrect;
        $answer->marks_awarded = $marksAwarded;
        $answer->remarks = $isCorrect ? 'Correct' : 'Incorrect';
        $answer->save();
    }
}
