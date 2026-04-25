<?php

use Illuminate\Support\Facades\Route;
use Modules\Quiz\Http\Controllers\Api\QuizController;
use Modules\Quiz\Http\Controllers\Api\QuestionController;

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('role:tutor')->group(function () {
        Route::get('sessions',                          [QuizController::class, 'getSessions']);
        Route::prefix('quiz')->group(function () {
            Route::get('subjects-list', [QuizController::class, 'getSubjects']);
            Route::get('courses',       [QuizController::class, 'getCourses']);
        });
        Route::get('quizzes',                           [QuizController::class, 'getQuizzes']);
        Route::get('quiz',                              [QuizController::class, 'getQuiz']);
        Route::post('duplicate-quiz',                   [QuizController::class, 'duplicateQuiz']);
        Route::post('publish-quiz',                     [QuizController::class, 'publishQuiz']);
        Route::post('update-quiz-status',               [QuizController::class, 'quizStatus']);

        Route::get('quiz-attempts',                     [QuizController::class, 'quizAttempts']);

        Route::post('create-quiz',                      [QuizController::class, 'createQuiz']);
        Route::post('generate-ai-quiz',                 [QuizController::class, 'generateAiQuiz']);
        Route::post('update-quiz',                      [QuizController::class, 'updateQuiz']);

        Route::get('generate-ai-quiz-settings',         [QuizController::class, 'generateAiQuizSettings']);
        Route::post('quiz-settings',                    [QuizController::class, 'quizSettings']);
        Route::get('quiz-settings',                     [QuizController::class, 'getQuizSettings']);
        Route::get('questions',                         [QuestionController::class, 'getQuestions']);
        Route::delete('question',                       [QuestionController::class, 'deleteQuestion']);

        Route::prefix('question')->group(function () {
            Route::post('true-false',                   [QuestionController::class, 'createOrUpdateTrueFalse']);
            Route::post('mcq',                          [QuestionController::class, 'createOrUpdateMcq']);
            Route::post('fill-in-the-blank',            [QuestionController::class, 'createOrUpdateFillInTheBlank']);
            Route::post('short-answer',                 [QuestionController::class, 'createOrUpdateShortAnswer']);
            Route::post('open-ended-essay',             [QuestionController::class, 'createOrUpdateOpenEndedEssay']);
        });
        Route::get('quiz-questions',                    [QuizController::class, 'quizQuestions']);
        Route::post('mark-quiz',                        [QuizController::class, 'markQuiz']);
    });

    Route::get('quiz-result',                       [QuizController::class, 'quizResult']);

    Route::prefix('student')->middleware('role:student')->group(function () {
        Route::get('quizzes',                           [QuizController::class, 'getStudentQuizzes']);
        Route::get('quiz',                              [QuizController::class, 'getStudentQuiz']);
        Route::post('start-quiz',                       [QuizController::class, 'startQuiz']);
        Route::get('quiz-instructions',                 [QuizController::class, 'getQuizInstructions']);
        Route::get('quiz-attempt',                      [QuizController::class, 'getQuizAttempt']);
        Route::get('quiz-in-review',                    [QuizController::class, 'getQuizInReview']);
        Route::post('submit-question',                  [QuizController::class, 'submitQuestion']);
    });
});
