<?php

namespace App\Models;

use App\Casts\BookingStatus;
use App\Casts\OrderStatusCast;
use App\Jobs\DeleteGoogleCalendarEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SlotBooking extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];

     public static function boot() {
        parent::boot();
        self::deleting(function($booking) {
            $booking->bookingLog()->delete();
            if ($booking->status == 'active') {
                dispatch(new DeleteGoogleCalendarEvent($booking->booker, $booking->meta_data['event_id'] ?? null));
                dispatch(new DeleteGoogleCalendarEvent($booking->bookee, $booking->slot->meta_data['event_id'] ?? null));
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status'    => BookingStatus::class,
            'meta_data' => 'array'
        ];
    }

    public function booker(): BelongsTo {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function bookee(): BelongsTo {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function student(): HasOneThrough {
        return $this->hasOneThrough(Profile::class, User::class, 'id', 'user_id', 'student_id', 'id');
    }


    public function slot(): BelongsTo {
        return $this->belongsTo(UserSubjectSlot::class, 'user_subject_slot_id');
    }

    public function tutor(): HasOneThrough {
        return $this->hasOneThrough(Profile::class, User::class, 'id', 'user_id', 'tutor_id', 'id');
    }

    public function rating(): MorphOne {
        return $this->morphOne(Rating::class, 'ratingable');
    }

    public function orderItem(): MorphOne {
        return $this->morphOne(OrderItem::class, 'orderable')->whereHas('orders', function ($query) {
            $query->where('status', OrderStatusCast::$statuses['complete']);
        });
    }

    public function bookingLog(): HasMany {
        return $this->hasMany(BookingLog::class, 'booking_id');
    }
    public function dispute(): HasOne {
        return $this->hasOne(Dispute::class, 'disputable_id');
    }
}
