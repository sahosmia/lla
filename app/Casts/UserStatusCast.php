<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UserStatusCast implements CastsAttributes
{
    protected $status = [
        0 => 'inactive',
        1 => 'active',
    ];

    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return isset($this->status[$value]) ? $this->status[$value] : null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return isset($value) ? array_search($value, $this->status) : null;
    }

}
