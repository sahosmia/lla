<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model {
    use HasFactory;
    public $timestamps = false;

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

