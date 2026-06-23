<?php

namespace Modules\TrainingCalendar\Models;

use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingCalendar extends Model
{
    use SoftDeletes;

    public const TYPE_ONLINE = 'online';
    public const TYPE_OFFLINE = 'offline';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_CANCELLED = 'cancelled';

    protected $table;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'registration_deadline' => 'datetime',
            'event_datetime' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    public function __construct(array $attributes = [])
    {
        $this->table = (config('trainingcalendar.db_prefix') ?? 'training_calendar_') . 'training_calendars';
        parent::__construct($attributes);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(TrainingRegistration::class, 'training_calendar_id');
    }

    public function paidRegistrations(): HasMany
    {
        return $this->registrations()->where('payment_status', TrainingRegistration::PAYMENT_PAID);
    }

    public function notices(): HasMany
    {
        return $this->hasMany(TrainingNotice::class, 'training_calendar_id');
    }

    public function orderItem(): MorphOne
    {
        return $this->morphOne(OrderItem::class, 'orderable');
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isRegistrationOpen(): bool
    {
        if (!$this->isPublished()) {
            return false;
        }

        if (trainingCalendarSetting('enforce_registration_deadline', 'yes') === 'yes') {
            if (now()->greaterThan($this->registration_deadline)) {
                return false;
            }
        }

        if (trainingCalendarSetting('enable_seat_limit', 'yes') === 'yes') {
            $maxSeats = $this->max_seats ?: (int) trainingCalendarSetting('default_max_seats', 50);
            if ($this->paidRegistrations()->count() >= $maxSeats) {
                return false;
            }
        }

        return true;
    }

    public function isFree(): bool
    {
        return (float) $this->price <= 0;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
