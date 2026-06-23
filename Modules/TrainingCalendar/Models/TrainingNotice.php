<?php

namespace Modules\TrainingCalendar\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingNotice extends Model
{
    protected $table;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function __construct(array $attributes = [])
    {
        $this->table = (config('trainingcalendar.db_prefix') ?? 'training_calendar_') . 'training_notices';
        parent::__construct($attributes);
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(TrainingCalendar::class, 'training_calendar_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
