<?php

namespace Modules\Courses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;


class Media extends Model
{
    use HasFactory;

    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'media';
    }

    protected $fillable = [
        'mediable_id',
        'mediable_type',
        'type',
        'path',
    ];
}
