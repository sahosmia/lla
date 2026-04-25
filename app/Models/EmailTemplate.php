<?php

namespace App\Models;

use App\Casts\SerializeCast;
use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model {
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'id',
        'title',
        'type',
        'role',
        'content',
        'status'
    ];

    protected static function booted() {
        static::addGlobalScope(new ActiveScope);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => SerializeCast::class,
        ];
    }

}
