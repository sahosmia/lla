<?php

namespace App\Models;

use App\Casts\GenderCast;
use App\Casts\RecommendTutorCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Profile extends Model {

    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender'        => GenderCast::class,
            'recommend_tutor' => RecommendTutorCast::class,


        ];
    }

    /**
     * Get the user that owns the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Getter of full name
     */
    protected function fullName(): Attribute {
        return Attribute::make(
            get: fn () => ucwords("$this->first_name $this->last_name")
        );
    }

    /**
     * Getter of short name
     */
    protected function shortName(): Attribute {
        return Attribute::make(
            get: fn () => ucwords($this?->first_name.' '. Str::charAt($this?->last_name, 0))
        );
    }

    /**
     * Getter of is verified attribute
     */
    public function isVerified(): Attribute {
        return Attribute::make(
            get: fn () => $this->verified_at ?? false,
        );
    }

    /**
     * Getter of is is featured attribute
     */
    public function isFeatured(): Attribute {
        return Attribute::make(
            get: fn () => $this->feature_expired_at &&  $this->feature_expired_at > Carbon::now()
        );
    }

      /**
     * Getter of is is profile image attribute
     */

     public function profileImage(): Attribute {
        return Attribute::make(
            get: fn () => !empty($this->image) && Storage::disk(getStorageDisk())->exists($this->image) ? url(Storage::url($this->image)) : (setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url('placeholder.png')))
        );
    }

}
