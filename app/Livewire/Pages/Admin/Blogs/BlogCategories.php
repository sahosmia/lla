<?php

namespace App\Livewire\Pages\Admin\Blogs;

use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Component;

class BlogCategories extends Component
{
    use WithPagination, WithFileUploads;

    public $editMode = false;
    public $name, $description, $edit_id, $image, $old_image, $slug, $status, $parent_cate_name;
    public $search              = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $delete_id           = null;
    public $selectedCategories  = [];
    public $selectAll           = false;
    public $allowImageSize      = false;
    public $allowImageExt;
    public $parentId            = null;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners = ['deleteConfirmRecord' => 'deleteCategory'];

    public function mount()
    {
        $this->per_page_opt     = perPageOpt();
        $per_page_record        = setting('_general.per_page_record');
        $image_file_ext         = setting('_general.image_file_ext');
        $image_file_size        = setting('_general.image_file_size');
        $this->per_page         = !empty($per_page_record) ? $per_page_record : 10;
        $this->allowImageSize   = !empty($image_file_size) ? $image_file_size : '3';
        $this->allowImageExt    = !empty($image_file_ext) ?  explode(',', $image_file_ext)  : ['jpg', 'png'];
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        if (empty($this->parent_cate_name)) {
            $this->parent_cate_name = __('general.select');
        }

        $categories             = $this->Categories; // get mounted property
        $allow_image_ext        = $this->allowImageExt;
        $allow_image_size       = $this->allowImageSize;

        return view('livewire.pages.admin.blog-categories.categories', compact('categories', 'allow_image_ext', 'allow_image_size'));
    }

    public function loadData()
    {
        $categories_tree = BlogCategory::tree()->get()->toTree()->toArray();
        $categories_tree = hierarchyTree($categories_tree);
        $this->dispatch('initDropDown', categories_tree: $categories_tree, parentId: $this->parentId);
    }

    public function getCategoriesProperty()
    {

        $blog_categories = BlogCategory::query();

        if (!empty($this->search)) {
            $blog_categories->where(function ($query) {
                $query->whereAny(['name', 'description'], 'like', '%' . $this->search . '%');
            });
        }

        return $blog_categories->orderBy('id', $this->sortby)->paginate($this->per_page);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedCategories = $this->Categories->pluck('id')->toArray();
        } else {
            $this->selectedCategories = [];
        }
    }

    public function updatedselectedCategories()
    {
        $this->selectAll = false;
    }

    private function resetInputfields()
    {

        $this->name                     = null;
        $this->description              = null;
        $this->image                    = null;
        $this->old_image                = array();
        $this->parentId                 = null;
        $this->delete_id                = null;
        $this->slug                     = null;
        $this->status                   = null;
        $this->selectedCategories       = [];
        $this->selectAll                = false;
        $this->parent_cate_name         = null;
        $this->edit_id                  = null;

        $categories_tree = BlogCategory::tree()->get()->toTree()->toArray();
        $categories_tree = hierarchyTree($categories_tree);
        $this->dispatch('initDropDown', categories_tree: $categories_tree, parentId: $this->parentId);;
    }


    #[On('delete-category')]
    public function delete($params = [])
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
        if (!empty($params['id'])) {
            BlogCategory::findOrFail($params['id'])->delete();
            $message = __('blogs.category_deleted_successfully');
        } elseif (!empty($this->selectedCategories)) {
            BlogCategory::whereIn('id', $this->selectedCategories)->delete();
            $message = __('blogs.categories_deleted_successfully');
        }

        $this->selectedCategories = [];
        $this->resetInputfields();

        $this->dispatch('showAlertMessage', type: 'success', message: $message);
    }

    public function deleteAllRecord()
    {
        if (!empty($this->selectedCategories)) {
            BlogCategory::whereIn('id', $this->selectedCategories)->delete();
            $this->selectedCategories = [];
        }
        $this->dispatch('delete-category-confirm');
    }

    public function removeImage()
    {

        $this->image     = null;
        $this->old_image = array();
    }

    public function edit($id)
    {

        $record = BlogCategory::findOrFail($id);
        $this->edit_id      = $id;
        $this->name         = $record->name;
        $this->description  = $record->description;
        $this->old_image    = !empty($record->image) ? unserialize($record->image) : array();
        $this->parentId     = $record->parent_id;
        $this->status       = $record->status;
        $this->editMode     = true;

        $categories_tree = BlogCategory::tree()->whereNot('id', $this->edit_id)->get()->toTree()->toArray();
        $categories_tree = hierarchyTree($categories_tree);
        $this->dispatch('initDropDown', categories_tree: $categories_tree, parentId: $this->parentId);
    }

    public function updateStatus($isChecked)
    {
        $this->status = $isChecked ? 'active' : 'inactive';
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

        $validated_data  = $this->validate([
            'name'              => 'required|max:255|unique:blog_categories,name,' . $this->edit_id,
            'image'             => 'nullable|image|mimes:' . join(',', $this->allowImageExt) . '|max:' . $this->allowImageSize * 1024,
        ], [
            'max'           => __('general.max_file_size_err',  ['file_size' => $this->allowImageSize . 'MB']),
            'mimes'         => __('general.invalid_file_type', ['file_types' => join(',', $this->allowImageExt)]),
            'unique'        => __('blogs.category_exists'),
        ]);

        $validated_data['name']         = sanitizeTextField($this->name);
        $validated_data['description']  = sanitizeTextField($this->description, true);
        $validated_data['slug']         = $validated_data['name'];
        $validated_data['parent_id']    = $this->parentId;

        if (!is_null($this->status) && in_array($this->status, ['active', 'inactive'])) {
            $validated_data['status']   = $this->status;
        }


        if ($this->image) {
            $image_path = $this->image->store('blog-categories', getStorageDisk());
            $image_name = $this->image->getClientOriginalName();
            $mime_type  = $this->image->getMimeType();


            $imageObject = array(
                'file_name'  => $image_name,
                'file_path'  => $image_path,
                'mime_type'  => $mime_type,
            );

            $validated_data['image']  = serialize($imageObject);
        } elseif (!empty($this->old_image)) {
            $validated_data['image'] = !empty($this->old_image) ? serialize($this->old_image) : null;
        }

        BlogCategory::updateOrCreate(['id' => $this->edit_id], $validated_data);

        if (!empty($this->edit_id)) {
            $message = __('blogs.category_updated_');
        } else {
            $message = __('blogs.category_created_');
        }

        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $this->dispatch('showAlertMessage', type: 'success', message: $message);
        $this->dispatch('updatecategoryList');
        $this->resetInputfields();
        $this->editMode = false;
    }
}
