<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class IdentityStatusCast implements CastsAttributes
{

    protected $statuses = [
        0 => 'pending',
        1 => 'accepted',
        2 => 'rejected',
    ];

    public function get($model, string $key, $value, array $attributes)
    {
        return $this->statuses[$value] ?? null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return array_search($value, $this->statuses, true);
    }
}
