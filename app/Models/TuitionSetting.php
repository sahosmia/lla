<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionSetting extends Model {
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'user_id',
        'available_offline',
        'available_online',
        'offline_student_place',
        'offline_tutor_place',
        'timezone'
    ];

    public function address() {
        return $this->morphOne(Address::class, 'addressable');
    }
}
