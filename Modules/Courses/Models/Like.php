<?php

namespace Modules\Courses\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'likes';
    }


    protected $fillable = [
        'likeable_id',
        'likeable_type',
        'user_id',
    ];


    /**
     * Get the user that liked the likeable.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
