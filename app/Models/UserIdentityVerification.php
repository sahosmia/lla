<?php

namespace App\Models;

use App\Casts\IdentityStatusCast;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Cache;

class UserIdentityVerification extends Model {
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;


    protected function casts(): array
    {
        return [
            'status'        => IdentityStatusCast::class,
            'attachments'   => 'array'
        ];
    }

    public function address(): MorphOne {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

