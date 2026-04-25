<?php

namespace Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'position'
    ];

    /**
     * Relationship: Option belongs to a Question
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }


    public function image()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('quiz.db_prefix') . 'question_options';
    }
}
