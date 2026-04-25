<?php

use Illuminate\Support\Facades\Route;
use Modules\Quiz\Livewire\Pages\Student\QuizAttempt\QuizAttempt;
use Modules\Quiz\Livewire\Pages\Student\QuizDetails\QuizDetails;
use Modules\Quiz\Livewire\Pages\Student\QuizListing\QuizListing as QuizListingQuizListing;
use Modules\Quiz\Livewire\Pages\Student\QuizResult\QuizResult;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\CreateQuestion;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\QuizSettings;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\EditQuiz;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\QuestionManager;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\QuizAttempts;
use Modules\Quiz\Livewire\Pages\Tutor\QuizListing\QuizListing;
use Modules\Quiz\Livewire\Pages\Tutor\QuizMark\QuizMark;

Route::middleware(['locale', 'maintenance', 'enabled:Quiz'])->as('quiz.')->prefix(config('quiz.url_prefix'))->group(function () {

    Route::middleware(['auth', 'verified', 'onlineUser', 'role:tutor'])->name('tutor.')->group(function () {
        Route::get('/quiz/{quizId}/quiz-details', EditQuiz::class)->name('quiz-details');
        Route::get('/quiz/{quizId}/settings',      QuizSettings::class)->name('quiz-settings');
        Route::get('/create-quiz/{quizId}/question-manager',      QuestionManager::class)->name('question-manager');
        Route::get('/create-quiz/{quizId}/question-manager/{questionType}/{questionId?}',      CreateQuestion::class)->name('create-question');
        Route::get('/quiz/{quizId}/attempts', QuizAttempts::class)->name('quiz-attempts');
        Route::get('/quizzes', QuizListing::class)->name('quizzes');
        Route::get('/mark-quiz/{attemptId}', QuizMark::class)->name('quiz-mark');        
    });

    Route::middleware(['auth', 'verified', 'onlineUser', 'role:student|tutor'])->group(function () {
        Route::get('/quiz-result/{attemptId}',     QuizResult::class)->name('quiz-result');
    });

    Route::middleware(['auth', 'verified', 'onlineUser', 'role:student'])->name('student.')->group(function () {
        Route::get('/student/quizzes',      QuizListingQuizListing::class)->name('quizzes');
        Route::get('/quiz-details/{attemptId}',                QuizDetails::class)->name('quiz-details');
        Route::get('/attempt-quiz/{attemptId}',                QuizAttempt::class)->name('attempt-quiz');
    });
});
