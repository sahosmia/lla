<?php

namespace Modules\Courses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Curriculum extends Model
{

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'curriculums';
    }

    protected $fillable = [
        'section_id',
        'title',
        'description',
        'type',
        'media_path',
        'thumbnail',
        'article_content',
        'content_length',
        'sort_order',
        'is_preview',
    ];

    protected $casts = [
        'type' => 'string',
        'is_preview' => 'boolean',
    ];

    /**
     * Get the section that owns the curriculum.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function watchtime(): HasOne
    {
        return $this->hasOne(Watchtime::class)
            ->where('user_id', Auth::id());
    }
}
