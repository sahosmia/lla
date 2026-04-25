<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'options' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartable()
    {
        return $this->morphTo();
    }

    public function coupon(): BelongsTo|null 
    {
        if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
            return $this->belongsTo(\Modules\KuponDeal\Models\Coupon::class, 'coupon_id');
        }
        return null;
    }
}

