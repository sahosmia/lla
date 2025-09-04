<?php

namespace Modules\Upcertify\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
class Template extends Model
{
    protected $table;
 

    public function __construct() {
        $this->table = config('upcertify.db_prefix') . 'templates';
        parent::__construct();
    }

    protected $guarded = [];

    public const STATUSES = [
        'draft'             => 0,
        'publish'           => 1,
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'body' => 'array',
    ];

    /**
     * Get and set the status attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute {
        return Attribute::make(
            get: fn($value) => Arr::get(array_flip(self::STATUSES), $value, null),
            set: fn($value) => Arr::get(self::STATUSES, $value, null)
        );
    }
}
