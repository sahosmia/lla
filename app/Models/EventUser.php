<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUser extends Pivot
{
    protected $table = 'event_user';

    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'profession',
        'organization',
        'completed_at',
    ];
}
