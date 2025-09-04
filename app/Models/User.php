<?php

namespace App\Models;

use Amentotech\LaraGuppy\Traits\Chatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\UserStatusCast;
use App\Jobs\SendNotificationJob;
use App\Notifications\EmailNotification;
use App\Services\NotificationService;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Dispute;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, CanResetPasswordContract
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens, Chatable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'provider',
        'provider_id',
        'email_verified_at',
        'default_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => UserStatusCast::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    /**
     * Scope a query to only include inactive users.
     */
    public function scopeInactive(Builder $query): void
    {
        $query->where('status', 0);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function accountSetting(): HasMany
    {
        return $this->hasMany(AccountSetting::class, 'user_id');
    }

    public function identityVerification(): HasOne
    {
        return $this->hasOne(UserIdentityVerification::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(UserSubjectGroup::class)->orderBy('sort_order');
    }

    public function subjects(): HasManyThrough
    {
        return $this->hasManyThrough(UserSubjectGroupSubject::class, UserSubjectGroup::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Rating::class, 'tutor_id');
    }
    
    public function role(): Attribute
    {
     
        return Attribute::make(
            get: function () {
                $activeRoleId = Session::get('active_role_id' . $this->id);
                if ($activeRoleId) {
                    return Role::find($activeRoleId)?->name;
                }
            
                return $this->default_role;
            }
        );
    }
    

    public static function admin() {
        return self::with('profile:id,user_id,first_name,last_name,image')->role('admin')->first();
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function redirectAfterLogin(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->role) {
                'admin'     => route('admin.insights', absolute: false),
                'sub_admin' => route('admin.profile', absolute: false),
                'tutor'     => route('tutor.dashboard', absolute: false),
                'student'   => route('student.bookings', absolute: false),
                default     => url('/')
            },
        );
    }

    public function isOnline(): Attribute
    {
        return Attribute::make(
            get: fn() => Cache::has('user-online-' . $this->id),
        );
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class);
    }

    /**
     * Get the experiences for the user.
     */
    public function experiences()
    {
        return $this->hasMany(UserExperience::class);
    }

    /**
     * Get the certificates for the user.
     */
    public function certificates()
    {
        return $this->hasMany(UserCertificate::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'user_languages');
    }

    public function tuitionSetting(): HasOne
    {
        return $this->hasOne(TuitionSetting::class);
    }

    public function billingDetail(): HasOne
    {
        return $this->hasOne(BillingDetail::class);
    }

    public function favouriteUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourite_users', 'user_id', 'favourite_user_id');
    }

    public function favouriteByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourite_users', 'favourite_user_id', 'user_id');
    }

    public function bookingSlots(): HasMany
    {
        return $this->hasMany(SlotBooking::class, 'tutor_id');
    }

    public function bookingOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function userPayouts()
    {
        return $this->hasMany(UserPayoutMethod::class);
    }

    public function wallet()
    {
        return $this->hasOne(UserWallet::class);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(UserWithdrawal::class);
    }

    // Relationship for pending withdrawals
    public function pendingWithdrawals(): HasMany
    {
        return $this->Withdrawals()->where('status', 'pending');
    }

    // Relationship for completed withdrawals
    public function completedWithdrawals(): HasMany
    {
        return $this->Withdrawals()->where('status', 'paid');
    }

    public function sendPasswordResetNotification($token)
    {
        dispatch(new SendNotificationJob('passwordResetRequest', $this, ['token' => $token, 'userEmail' => $this->email, 'userName' => $this->profile->full_name]));
    }

    public function userWallet(): HasOne
    {
        return $this->hasOne(UserWallet::class, 'user_id');
    }

    public function createdDisputes()
    {
        return $this->hasMany(Dispute::class, 'creator_by');
    }

    public function responsibleDisputes()
    {
        return $this->hasMany(Dispute::class, 'responsible_by');
    }
    
    public function socialProfiles(): HasMany
    {
        return $this->hasMany(SocialProfile::class);
    }

    /**
     * Get the badges that the user has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function badges(): BelongsToMany | null
    {
        if (\Nwidart\Modules\Facades\Module::has('starup') && \Nwidart\Modules\Facades\Module::isEnabled('starup')) {
            return $this->belongsToMany(\Modules\Starup\Models\Badge::class,  getStarupDbPrefix(). 'user_badges', 'user_id', 'badge_id');
        }
        return null;
    }

     /**
     * Get the courses for the user.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(\Modules\Courses\Models\Course::class, 'instructor_id');

    }
}
