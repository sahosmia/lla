<?php

namespace Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AttemptedQuestion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'question_option_id',
        'answer',
        'is_correct',
        'marks_awarded',
        'remarks',
    ];

    /**
     * Get the question associated with the attempted question.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */

    public function getTable(): string
    {
        return config('quiz.db_prefix') . 'attempted_questions';
    }

    /**
     * Get the attempted status of the question.
     */
    protected function isAttempted(): Attribute
    {
        return Attribute::make(
            get: fn() => !empty($this->answer) || !empty($this->question_option_id)
        );
    }
}
