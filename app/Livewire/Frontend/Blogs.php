<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Blog;
use App\Models\BlogCategory;
use Livewire\WithPagination;

class Blogs extends Component
{
    use WithPagination;

    public $keyword = '';
    public $searchDescription = '';
    public $category_id = '';
    public $orderBy = 'desc';
    public $perPage;
    public $categories;


    public function mount()
    {
        $this->perPage = setting('_front_page_settings.per_page') ?? 9;
        $this->categories = BlogCategory::orderBy('name', 'asc')->get();
    }

    public function render()
    {
        $categorySlug = request()->query('category');
        if ($categorySlug) {
            $category = BlogCategory::where('slug', $categorySlug)->first();
            if ($category) {
                $this->category_id = $category->id;
            }
        }

        $blogs = Blog::query()
            ->where('status', Blog::STATUSES['published'])
            ->when($this->keyword, function ($query) {
                $query->whereAny(['title', 'description'], 'LIKE', "%$this->keyword%");
            })
            ->when($this->category_id, function ($query) {
                $query->whereHas('categories', function ($query) {
                    $query->where('blog_category_id', $this->category_id);
                });
            })
            ->with(['categories', 'tags'])
            ->orderBy('id', $this->orderBy ?? 'desc')
            ->paginate($this->perPage);

        return view('livewire.pages.blogs', ['blogs' => $blogs])->extends('layouts.frontend-app', ['pageTitle' => (setting('_front_page_settings.blog_title') ?? 'Blogs')]);
    }

    public function updatedKeyword()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedCategoryId()
    {
        $this->resetPage();
    }

    public function updatedOrderBy()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->keyword = '';
        $this->category_id = '';
        $this->orderBy = 'desc';
        $this->perPage = setting('_front_page_settings.per_page') ?? 9;

        $this->resetPage();

        $this->dispatch('clear_filters');
    }
}
