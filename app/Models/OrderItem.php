<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model {
    use HasFactory;

    public $guarded = [];

    public $timestamps = true;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'options' => 'array',
    ];

    public function orderable(): MorphTo
    {
        return $this->morphTo('orderable');
    }

    public function orders(): BelongsTo {
        return $this->BelongsTo(Order::class,'order_id');
    }
}
