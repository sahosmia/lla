<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date_time',
        'sort_date',
        'mode',
        'user_id',
        'banner_image',
    ];

    protected $casts = [
        'sort_date' => 'datetime',
    ];

    /**
     * Get the trainer (tutor) for the event.
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the users registered for the event.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->withPivot(['name', 'email', 'profession', 'organization', 'completed_at'])
            ->withTimestamps();
    }

}
