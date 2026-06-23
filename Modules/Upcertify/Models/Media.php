<?php

namespace Modules\Upcertify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Arr;

class Media extends Model
{
    protected $table;
 

    public const TYPE = [
        'attachment'  => 0,
        'media'       => 1,
        'thumbnail'   => 2,
        'default_bg'  => 3,
        'default_att' => 4,
        'pattern'  => 5,

    ];

    public function __construct() {
        parent::__construct();
        $this->table = config('upcertify.db_prefix') . 'media';
    }

    protected $guarded = [];

    /**
     * Get and set the status attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function type(): Attribute {
        return Attribute::make(
            get: fn($value) => Arr::get(array_flip(self::TYPE), $value, null),
        );
    }
}
