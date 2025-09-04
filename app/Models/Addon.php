<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
class Addon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUSES = [
        'disabled'        => 0,
        'enabled'         => 1,
    ];

    public $casts = [
        'meta_data' => 'array',
    ];
    

    /**
     * Get and set the status attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Arr::get(array_flip(self::STATUSES), $value, null),
            set: fn($value) => Arr::get(self::STATUSES, $value, null)
        );
    }

    /**
     * Check if the addon is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->status === 'enabled';
    }

    /**
     * Check if the addon is disabled.
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->status === 'disabled';
    }
}
