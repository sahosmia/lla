<?php

namespace Modules\Quiz\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class QuizStatusCast implements CastsAttributes
{
    /**
     * Mapping of integer codes to status labels.
     *
     * @var array
     */
    public static $statusMap = [
        'draft'         => 0,
        'published'     => 1,
        'archived'      => 2,
    ];

    /**
     * Cast the given value for retrieval.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return array_search($value, self::$statusMap, true) ?: $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // Convert the human-readable status to its integer equivalent, if it exists.
        return self::$statusMap[$value] ?? throw new InvalidArgumentException("Invalid status: $value");
    }
}
