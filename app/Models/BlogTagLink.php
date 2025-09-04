<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTagLink extends Model
{
    protected $fillable = ['blog_id', 'tag_id'];
}
