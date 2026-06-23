<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class BookingStatus implements CastsAttributes
{

    public static $statuses = [
        'active'      => 1,
        'rescheduled' => 2,
        'refunded'    => 3,
        'reserved'    => 4,
        'completed'   => 5,
        'disputed'    => 6,
    ];

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return array_search($value, self::$statuses) ?: $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return self::$statuses[$value] ?? $value;
    }
}
