<?php

namespace App\Observers;

use App\Models\Blog;
use Illuminate\Support\Str;

class BlogObserver
{
    /**
     * Handle the Blog "created" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */

    public function created(Blog $blog)
    {
        $slug            = Str::slug($blog->title);
        $blog->slug    = $this->uniqueSlug($slug, $blog);

        $blog->save();
    }

    /**
     * Create unique slug automatically
     * @return string unique slug
     */

    protected function uniqueSlug($slug, $blog)
    {
        if (BLog::whereSlug($slug)->whereNot('id', $blog->id)->exists()) {
            $slug = $slug . "-" . $blog->id;
        }
        return $slug;
    }
}
