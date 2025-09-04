<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSetting extends Model
{
    use HasFactory;

    public $guarded = [];
    public $timestamps = false;

    public $casts = [
        'meta_value' => 'array'
    ];

}
