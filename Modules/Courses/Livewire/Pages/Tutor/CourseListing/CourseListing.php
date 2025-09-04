<?php

namespace Modules\Courses\Livewire\Pages\Tutor\CourseListing;

use Modules\Courses\Models\Category;
use Modules\Courses\Models\Course;
use Livewire\Component;
use Modules\Courses\Services\CourseService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class CourseListing extends Component
{
    use WithPagination;

    public $isLoading = false;
    public $showClearFilters        = false;
    public $categories;
    public $counts                  = [];
    public $statuses                = [];
    public $parPageList             = [10, 20, 30, 50, 100, 200];
    public $perPage;
    public $filters                 = [
        'keyword'          => null,
        'category_id'      => null,
        'per_page'         => 10,
        'min_price'        => null,
        'max_price'        => null,
    ];
    public $category_id = null;

    public function mount()
    {
        $this->showClearFilters = false;
        $this->perPage = setting('_general.per_page_record') ?? 10;
        $this->isLoading = true;
        $this->categories = Category::whereParentId(null)->get();
        $this->statuses     = Course::STATUSES;
        $allCourses  = (new CourseService())->getAllCourses(auth()->user()?->id);
        $this->counts = [
            'draft'             => $allCourses->where('status', 'draft')->count(),
            'under_review'      => $allCourses->where('status', 'under_review')->count(),
            'need_revision'     => $allCourses->where('status', 'need_revision')->count(),
            'active'            => $allCourses->where('status', 'active')->count(),
            'inactive'          => $allCourses->where('status', 'inactive')->count(),
        ];

        $this->dispatch('initSelect2', target: '.am-select2');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $courses = [];
        if (!$this->isLoading) {
            $courses = (new CourseService())->getCourses(
                instructorId: auth()->user()?->id,
                with: ['category', 'pricing', 'thumbnail','enrollments.student:id,user_id,first_name,last_name,slug,image'],
                withCount: ['enrollments'],
                filters: $this->filters,
                perPage: $this->perPage
            );
        }

        return view('courses::livewire.tutor.course-listing.course-listing', compact('courses'));
    }

    public function updatedFilters()
    {
        $this->showClearFilters = true;
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->filters = [
            'keyword'          => null,
            'category_id'      => null,
            'min_price'        => null,
            'max_price'        => null,
            'per_page'         => 10,
            'status'           => null,
        ];
        $this->showClearFilters = false;
        $this->resetPage();
        $this->dispatch('resetFilters');
    }

    public function loadData()
    {
        $this->isLoading = false;
        $this->dispatch('loadPageJs');
    }

    #[On('delete-course')]
    public function deleteCourse($params = [])
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $deleted = (new CourseService())->deleteCourse($params['id']);
        if ($deleted) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.course_deleted'), message: __('courses::courses.course_deleted_successfully'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error_title'), message: __('courses::courses.course_delete_failed'));
        }
    }

    public function toggleFeatured($id)
    {
        $course = Course::find($id);
        $course->featured = !$course->featured;
        $course->save();
        $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.course_updated'), message: __('courses::courses.course_updated_successfully'));
    }
}
