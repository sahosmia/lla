<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'image', 'author_id', 'slug', 'meta_title', 'meta_description'];

    public const STATUSES = [
        'draft'             => 0,
        'published'         => 1,
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_tag_links', 'blog_id', 'tag_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_category_link', 'blog_id', 'blog_category_id')
            ->where('status', 'active');
    }
}
