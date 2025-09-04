<?php

namespace App\Livewire\Pages\Admin\Blogs;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Tag;
use App\Traits\PrepareForValidation;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

class CreateBlog extends Component
{
    use WithPagination, WithFileUploads, PrepareForValidation;

    public $image;
    public $title, $meta_title, $meta_description, $description, $categories, $category_ids = [], $selectedCategories = [], $tags = [], $media, $status;
    public $editMode = false;
    public $edit_id;
    public $isLoading = true;
    public $blog;
    public $perPage = 10;
    public $selectedBlogs = [];
    public $selectAll = false;
    public $selectedCategory;
    public $content;
    public $editType = 'update';

    public $imageFileExt;
    public $imageFileSize;

    public function mount()
    {
        $this->categories = BlogCategory::whereStatus('active')->get(['id', 'name'])?->pluck('name', 'id')?->toArray();

        $this->imageFileExt = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $this->imageFileSize = (int) (setting('_general.max_image_size') ?? '5');
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

    public function rules(): array
    {
        return [
            'title'                 => 'required|string|max:255',
            'meta_title'            => 'required|string',
            'meta_description'      => 'required|string',
            'description'           => 'required|string',
            'category_ids'          => 'required|array|min:1',
            'category_ids.*'        => 'required|exists:blog_categories,id',
            'image'                 => 'required|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024,
        ];
    }

    public function store()
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
        $this->beforeValidation(['image', 'category_ids']);
        $validatedData = $this->validate($rules, [], ['category_ids' => 'categories']);

        if ($this->image) {
            $randomString = Str::random(30);
            $this->image->storeAs('blogs', $randomString . '.' . $this->image->getClientOriginalExtension(), getStorageDisk());
            $validatedData['image'] = 'blogs/' . $randomString . '.' . $this->image->getClientOriginalExtension();
        }

        $validatedData['status'] = $this->status ?? 'draft';
        $validatedData['author_id'] = auth()->user()->id;

        $blog = Blog::create($validatedData);

        $blog->categories()->attach($this->category_ids);

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
        if ($this->image) {
            $this->image = null;
        }
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'required|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024
        ], [
            'image.max' => __('blogs.image_size_validation', ['size' => $this->imageFileSize]),
        ]);
    }
}
