<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class UserSubjectSlot extends Model {
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time'    => 'datetime: Y-m-d H:i:s',
        'end_time'      => 'datetime:Y-m-d H:i:s',
        'meta_data'     => 'array'
    ];

    public function subjectGroupSubjects() {
        return $this->belongsTo(UserSubjectGroupSubject::class, 'user_subject_group_subject_id', 'id');
    }

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'user_subject_group_subjects', 'subject_id', 'id');
    }

    public function bookings(): HasMany{
        return $this->hasMany(SlotBooking::class, 'user_subject_slot_id');
    }

    public function students(): HasManyThrough{
        return $this->hasManyThrough(Profile::class, SlotBooking::class, 'user_subject_slot_id', 'user_id', 'id', 'student_id');
    }
    
}
