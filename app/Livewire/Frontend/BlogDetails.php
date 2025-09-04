<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Blog;
use Livewire\WithPagination;

class BlogDetails extends Component
{
    use WithPagination;

    public $blogSlug;
    public $blog;
    public $relatedBlogs;

    public function mount()
    {
        $this->blogSlug = request()->route('slug');

        $this->blog = Blog::where('slug', $this->blogSlug)
            ->when(request()->source != 'admin', function ($query) {
                $query->where('status', Blog::STATUSES['published']);
            })
            ->with('author.profile', 'tags')
            ->first();

        if (!$this->blog) {
            abort(404);
        }

        if (request()->source != 'admin') {
            $this->manageViews($this->blog);
        }

        $categoryIds = $this->blog->categories->pluck('id');

        if ($categoryIds->isNotEmpty()) {
            $this->relatedBlogs = Blog::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('blog_category_id', $categoryIds);
            })
                ->where('id', '!=', $this->blog->id)
                ->with(['author.profile', 'categories', 'tags'])
                ->where('status', Blog::STATUSES['published'])
                ->take(4)
                ->orderBy('updated_at', 'desc')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.pages.blog-details', [
            'relatedBlogs' => $this->relatedBlogs,
        ])->layout('layouts.frontend-app', ['pageTitle' => $this->blog?->meta_title, 'pageDescription' => $this->blog?->meta_description]);
    }

    public function getPageTitle()
    {
        return $this->blog ? $this->blog->title : 'Blogs'; // Fallback to 'Blogs' if blog isn't loaded yet
    }

    public function manageViews($blog)
    {
        $blogSessionKey = 'blog_viewed_' . $blog->id;

        if (!request()->session()->has($blogSessionKey)) {
            $blog->increment('views_count');
            request()->session()->put($blogSessionKey, true, 1440);
        }
    }
}
