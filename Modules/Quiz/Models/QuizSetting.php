<?php

namespace Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class QuizSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'meta_key',
        'meta_value',
    ];
    
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('quiz.db_prefix') . 'quiz_settings';
    }
    
    /**
     * Relationship: QuizMeta belongs to a Quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
