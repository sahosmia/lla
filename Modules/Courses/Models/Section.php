<?php

namespace Modules\Courses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Models\Curriculum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'sections';
    }

    protected $fillable = [
        'course_id',
        'title',
        'description',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get section curriculums
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function curriculums(): HasMany
    {
        return $this->hasMany(Curriculum::class);
    }
}
