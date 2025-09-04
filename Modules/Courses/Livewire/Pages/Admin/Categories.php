<?php

namespace Modules\Courses\Livewire\Pages\Admin;

use Modules\Courses\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Component;
use Modules\Courses\Models\Course;

class Categories extends Component
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
    public $parentId            = null;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners = ['deleteConfirmRecord' => 'deleteCategory'];

    public function mount()
    {
        $this->per_page_opt     = perPageOpt();
        $per_page_record        = setting('_general.per_page_record');
        $this->per_page         = !empty($per_page_record) ? $per_page_record : 10;
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        if (empty($this->parent_cate_name)) {
            $this->parent_cate_name = __('general.select');
        }

        $categories             = $this->Categories; // get mounted property

        return view('courses::livewire.admin.categories.categories', compact('categories'));
    }

    public function loadData()
    {
        $categories_tree = Category::whereNull('deleted_at')->whereNull('parent_id')->tree()->get()->toTree()->toArray();
        $categories_tree = hierarchyTree($categories_tree);
        $this->dispatch('initDropDown', categories_tree: $categories_tree, parentId: $this->parentId);
    }

    public function getCategoriesProperty()
    {

        $curses_categories = Category::query()->whereNull('deleted_at');

        if (!empty($this->search)) {
            $curses_categories->where(function ($query) {
                $query->whereAny(['name', 'description'], 'like', '%' . $this->search . '%');
            });
        }

        return $curses_categories->orderBy('id', $this->sortby)->paginate($this->per_page);
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

        $categories_tree = Category::whereNull('deleted_at')->whereNull('parent_id')->tree()->get()->toTree()->toArray();
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
            $category = Category::findOrFail($params['id']);
            $isParent = empty($category->parent_id);

            if ($isParent) {
                $courses = Course::where('category_id', $category->id)
                    ->whereHas('enrollments')
                    ->get();

                if ($courses->isNotEmpty()) {
                    $this->dispatch(
                        'showAlertMessage',
                        type: 'error',
                        title: __('general.error_title'),
                        message: __('courses::courses.category_has_courses')
                    );
                    return;
                }

                $courses = Course::where('category_id', $category->id)->get();
                foreach ($courses as $course) {
                    $course->delete();
                }

                $subCategories = Category::where('parent_id', $category->id)->get();
                foreach ($subCategories as $subCategory) {
                    $subCategory->delete();
                }
                $message = __('courses::courses.category_deleted_successfully');
            } else {
                $courses = Course::where('sub_category_id', $category->id)
                    ->whereHas('enrollments')
                    ->get();

                if ($courses->isNotEmpty()) {
                    $this->dispatch(
                        'showAlertMessage',
                        type: 'error',
                        title: __('general.error_title'),
                        message: __('courses::courses.category_has_courses')
                    );
                    return;
                }

                $courses = Course::where('sub_category_id', $category->id)->get();
                foreach ($courses as $course) {
                    $course->delete();
                }
            }
            
            $category->delete();

            $this->dispatch(
                        'showAlertMessage',
                        type: 'success',
                        title: __('general.error_title'),
                        message: __('courses::courses.category_deleted_successfully')
                    );
        }
    }

    public function deleteAllRecord()
    {
        if (!empty($this->selectedCategories)) {
            Category::whereIn('id', $this->selectedCategories)->delete();
            $this->selectedCategories = [];
        }
        $this->dispatch('delete-category-confirm');
    }


    public function edit($id)
    {

        $record = Category::findOrFail($id);
        $this->edit_id      = $id;
        $this->name         = $record->name;
        $this->description  = $record->description;
        $this->parentId     = $record->parent_id;
        $this->status       = $record->status;
        $this->editMode     = true;

        $categories_tree = Category::whereNull('parent_id')->tree()->whereNot('id', $this->edit_id)->get()->toTree()->toArray();
        $categories_tree = hierarchyTree($categories_tree);
        $this->dispatch('initDropDown', categories_tree: $categories_tree, parentId: $this->parentId);
    }

    public function updateStatus($isChecked)
    {
        $this->status = $isChecked ? 'active' : 'deactive';
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
            'name'              => 'required|max:255|unique:courses_categories,name,' . $this->edit_id,
        ]);

        $validated_data['name']         = sanitizeTextField($this->name);
        $validated_data['description']  = sanitizeTextField($this->description, true);
        $validated_data['slug']         = $validated_data['name'];
        $validated_data['parent_id']    = $this->parentId;

        if (!is_null($this->status) && in_array($this->status, ['active', 'deactive'])) {
            $validated_data['status']   = $this->status;
        }

        Category::updateOrCreate(['id' => $this->edit_id], $validated_data);

        if (!empty($this->edit_id)) {
            $message = __('courses::courses.category_updated');
        } else {
            $message = __('courses::courses.category_created');
        }

        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $this->dispatch('showAlertMessage', type: 'success', message: $message);
        $this->dispatch('updatecategoryList');
        $this->resetInputfields();
        $this->editMode = false;
    }
}
