<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model {

    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function booted() {
        static::addGlobalScope(new ActiveScope);
    }
    /**
     * Get all courses for the language
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses(): HasMany
    {
        return $this->hasMany(\Modules\Courses\Models\Course::class);
    }

    /**
     * Get all active courses for the language
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeCourses(): HasMany
    {
        return $this->hasMany(\Modules\Courses\Models\Course::class)->where('status', \Modules\Courses\Models\Course::STATUSES['active']);
    }
}
