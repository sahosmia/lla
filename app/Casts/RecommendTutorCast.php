<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class RecommendTutorCast implements CastsAttributes
{
    protected $RecommendTutor = [
        0 => 'no',
        1 => 'yes',
    ];

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $this->RecommendTutor[$value] ?? null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return !empty($value) ? array_search($value, $this->RecommendTutor) : null;
    }

}
