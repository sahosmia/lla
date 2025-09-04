<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryLink extends Model
{
    use HasFactory;

    protected $table = 'blog_category_link';
    protected $fillable = ['blog_id', 'blog_category_id'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
