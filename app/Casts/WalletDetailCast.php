<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class WalletDetailCast implements CastsAttributes
{
    public static $withdrawnTypes = [
        'add' => 1,
        'deduct_withdrawn' => 2,
        'deduct_refund' => 3,
        'pending_available' => 4,
        'deduct_booking' => 5,
    ];

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return array_search($value, self::$withdrawnTypes) ?: $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return self::$withdrawnTypes[$value] ?? $value;
    }
}
