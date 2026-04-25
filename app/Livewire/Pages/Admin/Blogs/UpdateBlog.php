<?php

namespace App\Livewire\Pages\Admin\Blogs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Traits\PrepareForValidation;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Str;

class UpdateBlog extends Component
{
    use WithPagination, WithFileUploads, PrepareForValidation;

    public $blogId;
    public $blog;
    public $image;

    public $categories;
    public $title, $meta_title, $slug, $meta_description, $description, $category_id, $selectedCategories = [], $category_ids = [], $tags = [], $media, $status;
    public $edit_id;
    public $isLoading = true;

    public $perPage = 10;
    public $selectedBlogs = [];
    public $selectAll = false;
    public $selectedCategory;
    public $content;
    public $editType = 'update';
    protected $paginationTheme = 'bootstrap';

    public $imageFileExt;
    public $imageFileSize;

    public function mount()
    {
        $this->blogId             = request()->route('id');
        $this->blog               = Blog::with('categories')->find($this->blogId);
        if (!$this->blog) {
            abort(404);
        }

        $this->title              = $this->blog->title;
        $this->slug              = $this->blog->slug;
        $this->meta_title         = $this->blog->meta_title;
        $this->meta_description   = $this->blog->meta_description;
        $this->description        = $this->blog->description;
        $this->category_ids       = $this->blog->categories->pluck('id')->toArray();
        $this->tags               = $this->blog->tags?->pluck('name')->toArray();

        $this->status = $this->blog->status;

        $this->imageFileExt = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $this->imageFileSize = (int) (setting('_general.max_image_size') ?? '5');

        $this->categories = BlogCategory::whereStatus('active')->get(['id', 'name'])?->pluck('name', 'id')?->toArray();

        $this->selectedCategories = $this->blog->categories->pluck('id')->toArray();
    }

    public function loadData()
    {
        $this->isLoading = false;
        $this->dispatch('loadPageJs');
        $this->dispatch('initSelect2', target: '#category_ids');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.create-blog');
    }

    public function updateStatus($isChecked)
    {
        $this->status = $isChecked ? 'published' : 'draft';
    }

    public function updatedPage()
    {
        if ($this->selectAll) {
            $this->selectedBlogs = $this->blogs->pluck('id')->toArray();
        }
    }

    public function rules(): array
    {

        return [
            'title'         => 'required|string|max:255',
            'slug'          => 'required|string|max:255|unique:blogs,slug,' . $this->blogId,
            'description'   => 'required|string',
            'category_ids'  => 'required|array|min:1',
            'category_ids.*'  => 'required|exists:blog_categories,id',
        ];
    }

    public function update()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                title: __('general.demosite_res_title'),
                message: __('general.demosite_res_txt')
            );
            return;
        }

        $rules = $this->rules();
        if (empty($this->blog->image)) {
            $rules['image'] = 'required|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024;
        }

        $this->beforeValidation(['image', 'category_ids']);

        $validatedData = $this->validate($rules, [], ['category_ids' =>  'categories']);

        if ($this->image) {
            $randomString = Str::random(30);
            $this->image->storeAs('blogs', $randomString . '.' . $this->image->getClientOriginalExtension(), getStorageDisk());
            $validatedData['image'] = 'blogs/' . $randomString . '.' . $this->image->getClientOriginalExtension();
        }

        $validatedData['status'] = $this->status ?? 'draft';

        $blog = Blog::findOrFail($this->blogId);
        $blog->update($validatedData);

        $blog->categories()->sync($this->category_ids);

        $blog->tags()->detach();
        if (!empty($this->tags)) {
            foreach ($this->tags as $tagName) {
                $tag = BlogTag::firstOrCreate(['name' => $tagName]);
                $blog->tags()->attach($tag);
            }
        }

        redirect(route('admin.blog-listing'));
    }

    public function removeImage()
    {
        if ($this->blog->image) {
            if (Storage::exists('public/blogs/' . $this->blog->image)) {
                Storage::delete('public/blogs/' . $this->blog->image);
            }

            $this->blog->image = null;
            $this->blog->save();
        }
        $this->image = null;
        if ($this->image) {
            $this->image = null;
        }
    }

    public function updatedImage()
    {

        $this->validate([
            'image' => 'required|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024
        ], [
            'image.max' => 'The image may not be greater than ' . $this->imageFileSize . ' MB.',
        ]);
    }
}
