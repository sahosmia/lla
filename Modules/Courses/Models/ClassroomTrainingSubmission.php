<?php

namespace Modules\Courses\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomTrainingSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_id',
        'name',
        'address',
        'phone',
        'profession',
        'organization',
        'reason',
    ];

    /**
     * Get the course that this submission belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user that this submission belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}