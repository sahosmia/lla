<?php

namespace App\Models;

use App\Models\Scopes\PositionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubjectGroup extends Model {
    use HasFactory;

    protected static function booted() {
        static::addGlobalScope(new PositionScope);
    }

    public $timestamps = false;

    public $fillable = [
        'user_id',
        'subject_group_id',
        'sort_order'
    ];

    public function group(): BelongsTo {
        return $this->belongsTo(SubjectGroup::class, 'subject_group_id', 'id');
    }

    public function subjects(): BelongsToMany {
        return $this->belongsToMany(Subject::class, 'user_subject_group_subjects', 'user_subject_group_id')->withPivot('id', 'hour_rate', 'description', 'image','sort_order')->orderBy('sort_order');
    }

    public function userSubjects(): HasMany {
        return $this->hasMany(UserSubjectGroupSubject::class);
    }

    public function tutorProfile() {
        return $this->hasOneThrough(Profile::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
    
    public function tutor(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
