<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class EmployementTypeCast implements CastsAttributes
{


    public static $statuses = [
        'full_time'     => 1,
        'part_time'     => 2,
        'self_employed' => 3,
        'contract'      => 4,
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
