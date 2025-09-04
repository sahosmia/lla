<?php

namespace Modules\Quiz\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Quiz\Casts\QuizResultCast;

class QuizAttempt extends Model
{
    /**
     * Quiz Results
     */
    const RESULT_ASSIGNED        = 'assigned';
    const RESULT_IN_REVIEW      = 'in_review';
    const RESULT_PASSED         = 'pass';
    const RESULT_FAILED         = 'fail';

    const ASSIGNED              = '0';
    const IN_REVIEW             = '1';
    const PASS                  = '2';
    const FAIL                  = '3';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'active_question_id',
        'student_id',
        'started_at',
        'completed_at',
        'total_questions',
        'total_marks',
        'correct_answers',
        'incorrect_answers',
        'earned_marks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'result'        => QuizResultCast::class,
        'started_at'    => 'datetime',
    ];

    /**
     * Relationship: QuizAttempt belongs to a Quiz
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Relationship: QuizAttempt belongs to a Student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function attemptedQuestions(): HasMany
    {
        return $this->hasMany(AttemptedQuestion::class);
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('quiz.db_prefix') . 'quiz_attempts';
    }
}
