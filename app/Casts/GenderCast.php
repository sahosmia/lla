<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class GenderCast implements CastsAttributes
{
    protected $genders = [
        1 => 'male',
        2 => 'female',
        3 => 'not_specified',
    ];

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return isset($this->genders[$value]) ? $this->genders[$value] : null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return !empty($value) ? array_search($value, $this->genders) : null;
    }

}
