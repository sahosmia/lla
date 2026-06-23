<?php

namespace Modules\TrainingCalendar\Models;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingRegistration extends Model
{
    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_FAILED = 'failed';

    protected $table;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = (config('trainingcalendar.db_prefix') ?? 'training_calendar_') . 'training_registrations';
        parent::__construct($attributes);
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(TrainingCalendar::class, 'training_calendar_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
