<?php

namespace Modules\Quiz\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class QuizResultCast implements CastsAttributes
{
    /**
     * Mapping of integer codes to quiz results.
     *
     * @var array
     */
    protected $statusMap = [
        0 => 'assigned',
        1 => 'in_review',
        2 => 'pass',
        3 => 'fail',

    ];

    /**
     * Mapping of status labels to integer codes.
     *
     * @var array
     */
    protected $reverseStatusMap;

    /**
     * Constructor to initialize the reverse mapping.
     */
    public function __construct()
    {
        $this->reverseStatusMap = array_flip($this->statusMap);
    }

    /**
     * Cast the given value from the database to the desired format.
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $this->statusMap[$value] ?? null;
    }

    /**
     * Prepare the given value for storage in the database.
     *
     * @throws \InvalidArgumentException
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('The quiz result must be a string.');
        }

        if (!isset($this->reverseStatusMap[$value])) {
            throw new InvalidArgumentException("Invalid quiz result: {$value}.");
        }

        return $this->reverseStatusMap[$value];
    }
}
