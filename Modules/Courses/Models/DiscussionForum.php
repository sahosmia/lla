<?php

namespace Modules\Courses\Models;

use Modules\Courses\Models\Like;
use App\Models\User;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DiscussionForum extends Model
{
    use HasFactory;

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'discussion_forums';
    }

    protected $fillable = [
        'description',
        'course_id',
        'parent_id',
        'created_by',
    ];

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionForum::class, 'parent_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by',);
    }
}
