<?php

namespace Modules\Courses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;


class Watchtime extends Model
{
    use HasFactory;

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'watchtimes';
    }

    protected $fillable = [
        'user_id',
        'course_id',
        'section_id',
        'curriculum_id',
        'duration',
    ];
}
