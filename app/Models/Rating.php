<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model {
    public $guarded = [];
    
    use HasFactory;

    /**
     * Get the author for the rating
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author(): HasOne {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    /**
     * Get the profile for the rating
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function profile(): HasOneThrough {
        return $this->hasOneThrough(Profile::class, User::class, 'id', 'user_id', 'student_id', 'id');
    }

    /**
     * Get the address for the rating
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function address(): MorphOne {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Get the student for the rating
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    /**
     * Get the tutor for the rating
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tutor(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'tutor_id');
    }

    public function ratingable(): MorphTo
    {
        return $this->morphTo();
    }
}
