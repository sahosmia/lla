<?php

namespace Modules\Courses\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Enrollment extends Model
{


    use HasFactory;

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'enrollments';
    }

    public const STATUSES = [
        'active'    => 1
    ];


    protected $guarded = [];


    /**
     * Get and set the status attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Arr::get(array_flip(self::STATUSES), $value, null),
            set: fn($value) => Arr::get(self::STATUSES, $value, null)
        );
    }

    /**
     * Get the course for the enrollment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the course progress for the enrollment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseProgress(): HasMany
    {
        return $this->hasMany(Watchtime::class, 'course_id', 'course_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'student_id', 'user_id');
    }
}
