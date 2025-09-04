<?php

namespace App\Models;

use App\Casts\OrderStatusCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Models\Country;

class Order extends Model {
    use HasFactory;

    public $guarded = [];
    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'status'        => OrderStatusCast::class,
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($order) {
            $order->items()->delete();
        });
    }

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class,'order_id');
    }

    public function userProfile(): HasOneThrough {
        return $this->hasOneThrough(Profile::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }

    public function orderBy(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function countryDetails()
    {
        return $this->belongsTo(Country::class, 'id');
    }
}
