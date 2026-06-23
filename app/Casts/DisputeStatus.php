<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DisputeStatus implements CastsAttributes
{

    public static $statuses = [
        'closed'        => 0,
        'pending'       => 1,
        'under_review'  => 2,
        'in_discussion' => 3,
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
