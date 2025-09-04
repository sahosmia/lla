<?php

namespace Modules\Courses\Models;

use App\Models\Language;
use App\Models\OrderItem;
use App\Models\Rating;
use App\Models\User;
use Modules\Assignments\Models\Assignment;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'courses';
    }

    protected $fillable = [
        'instructor_id',
        'title',
        'subtitle',
        'description',
        'duration',
        'category_id',
        'sub_category_id',
        'level',
        'status',
        'type',
        'tags',
        'learning_objectives',
        'prerequisites',
        'language_id',
        'content_length',
        'meta_data',
        'created_at',
        'updated_at',
        'discussion_forum',
        'certificate_id'
    ];


    public $casts = [
        'tags'                      => 'array',
        'learning_objectives'       => 'array',
        'discussion_forum'          => 'boolean',
        'meta_data'                 => 'array'
    ];

    public const STATUSES = [
        'draft'             => 1,
        'under_review'      => 2,
        'need_revision'     => 3,
        'active'            => 4,
        'inactive'          => 5,
    ];

    public const STATUS_COLOR = [
        'draft'             => '#FFA500',
        'under_review'      => '#0000FF',
        'need_revision'     => '#F79009', //FF0000
        'active'            => '#008000',
        'inactive'          => '#808080',
    ];

    public const TYPES = [
        'video'             => 1,
        'audio'             => 2,
        'live'              => 3,
        'article'           => 4,
        'all'               => 5,
    ];

    public const LEVEL = [
        'beginner'          => 1,
        'intermediate'      => 2,
        'expert'            => 3,
        'all'               => 4,
    ];

    /**
     * Get and set the status attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Arr::get(array_flip(self::STATUSES), $value, null),
            set: fn($value) => Arr::get(self::STATUSES, $value, null)
        );
    }

    /**
     * Get the status color attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn() => Arr::get(self::STATUS_COLOR, $this->status, null)
        );
    }

    /**
     * Get and set the type attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Arr::get(array_flip(self::TYPES), $value, null),
            set: fn($value) => Arr::get(self::TYPES, $value, null)
        );
    }

    /**
     * Get and set the level attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function level(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Arr::get(array_flip(self::LEVEL), $value, null),
            set: fn($value) => Arr::get(self::LEVEL, $value, null)
        );
    }


    /**
     * Get category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get sub category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    /**
     * Get language.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get course thumbnail
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function thumbnail(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('thumbnail');
    }

    /**
     * Get course promotional video
     *
     */
    public function promotionalVideo(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('promotional_video');
    }

    /**Get course media */
    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    /**
     * Get the pricing for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pricing(): HasOne
    {
        return $this->hasOne(Pricing::class);
    }

    /**
     * Get the promotions for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    /**
     * Get the FAQs for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    /**
     * Get the tutor for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get instructor reviews
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instructorReviews(): HasManyThrough
    {
        return $this->hasManyThrough(Rating::class, User::class, 'id', 'tutor_id', 'instructor_id', 'id')->where('ratingable_type', User::class);
    }

    /**
     * Get course section
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Get course curriculums
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function curriculums(): HasManyThrough
    {
        return $this->hasManyThrough(Curriculum::class, Section::class);
    }

    /**
     * Get course curriculums of video type
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function videoCurriculums(): HasManyThrough
    {
        return $this->hasManyThrough(Curriculum::class, Section::class)->where('type', 'video');
    }

    /**
     * Get the ratings for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    /**
     * Get the likes for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Get the noticeboards for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function noticeboards(): HasMany
    {
        return $this->hasMany(Noticeboard::class);
    }

    /**
     * Get the watchtime for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseWatchtime(): HasMany
    {
        return $this->hasMany(Watchtime::class)->where('user_id', Auth::id());
    }

    public function courseWatchedtime(): HasMany
    {
        return $this->hasMany(Watchtime::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the order item for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function orderItem(): MorphOne
    {
        return $this->morphOne(OrderItem::class, 'orderable');
    }


    /**
     * Get the quizzes for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizzes(): HasMany
    {
        if (isActiveModule('Quiz')) {
            return $this->hasMany(\Modules\Quiz\Models\Quiz::class, 'quizzable_id')->where('quizzable_type', self::class)->where('status', \Modules\Quiz\Models\Quiz::PUBLISHED);
        }

        return null;
    }

    /**
     * Get the assignments for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignments(): HasMany | null
    {
        if (isActiveModule('assignments')) {
            return $this->hasMany(\Modules\Assignments\Models\Assignment::class, 'related_id')->where('related_type', self::class)->where('status', \Modules\Assignments\Models\Assignment::STATUS_PUBLISHED);
        }
        return null;
    }
}
