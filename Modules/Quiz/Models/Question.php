<?php

namespace Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Quiz\Models\Media;
use Modules\Quiz\Casts\QuestionTypeCast;

class Question extends Model
{
    /**
     * Question Types
     */
    const TYPE_TRUE_FALSE           = 'true_false';
    const TYPE_MCQ                  = 'mcq';
    const TYPE_OPEN_ENDED_ESSAY     = 'open_ended_essay';
    const TYPE_FILL_IN_BLANKS       = 'fill_in_blanks';
    const TYPE_SHORT_ANSWER         = 'short_answer';

    const MCQ                  = '1';
    const TRUE_FALSE           = '2';
    const OPEN_ENDED_ESSAY     = '3';
    const FILL_IN_BLANKS       = '4';
    const SHORT_ANSWER         = '5';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'type',
        'title',
        'description',
        'settings',
        'points',
        'position',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type'                  => QuestionTypeCast::class,
        'settings'              => 'array',
    ];

    /**
     * Relationship: Question belongs to a Quiz
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Relationship: Question has many Options
     */
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('quiz.db_prefix') . 'questions';
    }

    /**
     * Get question image
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function thumbnail(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'image');
    }

    /**
     * Get question video
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function video(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'video');
    }

    /**
     * Get all media associated with the question
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function attemptedQuestions(): HasMany
    {
        return $this->hasMany(AttemptedQuestion::class);
    }

    /**
     * Check if question requries descriptive answer
     *
     * @return bool
     */
    public function isDescriptive(): bool
    {
        return in_array($this->type, [
            Question::TYPE_OPEN_ENDED_ESSAY,
            Question::TYPE_SHORT_ANSWER,
        ]);
    }

    /**
     * Check if question has multiple options
     *
     * @return bool
     */
    public function isMultiOption(): bool
    {
        return in_array($this->type, [
            Question::TYPE_MCQ,
            Question::TYPE_TRUE_FALSE,
        ]);
    }

    /**
     * Check if question is Fill in blanks
     *
     * @return bool
     */
    public function isFillInBlanks(): bool
    {
        return $this->type == Question::TYPE_FILL_IN_BLANKS;
    }
}
