<?php

namespace App\Observers;

use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryObserver
{
    /**
     * Handle the BlogCategory "created" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */

    public function created(BlogCategory $category)
    {
        $slug            = Str::slug($category->name);
        $category->slug    = $this->uniqueSlug($slug, $category);

        $category->save();
    }

    /**
     * Create unique slug automatically
     * @return string unique slug
     */

    protected function uniqueSlug($slug, $category)
    {
        if (BlogCategory::whereSlug($slug)->whereNot('id', $category->id)->exists()) {
            $slug = $slug . "-" . $category->id;
        }
        return $slug;
    }
}
