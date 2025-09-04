<?php

namespace Modules\Quiz\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class QuestionTypeCast implements CastsAttributes
{
    /**
     * Mapping of integer codes to question types.
     *
     * @var array
     */
    protected $statusMap = [
        1 => 'mcq',
        2 => 'true_false',
        3 => 'open_ended_essay',
        4 => 'fill_in_blanks',
        5 => 'short_answer',
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
            throw new InvalidArgumentException('The question type must be a string.');
        }

        if (!isset($this->reverseStatusMap[$value])) {
            throw new InvalidArgumentException("Invalid question type: {$value}.");
        }

        return $this->reverseStatusMap[$value];
    }
}
