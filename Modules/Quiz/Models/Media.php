<?php

namespace Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mediable_id',
        'mediable_type',
        'type',
        'path',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string 
    {
        return config('quiz.db_prefix') . 'media';
    }
}
