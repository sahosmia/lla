<?php

namespace Modules\Courses\Livewire\Pages\Admin;

use Modules\Courses\Services\CourseService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CourseEnrollments extends Component
{
    use WithPagination;

   
    public $search = '';
    public $sortby = 'desc';
    public $status = '';
    private ?CourseService $courseService = null;


    public function boot()
    {
        $this->courseService = new CourseService();
    }

    public function mount()
    {
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $courses = $this->courseService->getCourseEnrollments($this->search, $this->status, $this->sortby);

        return view('courses::livewire.admin.course-enrollments', [
            'orders' => $courses
        ]);
    }

    public function updated($propertyName)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if (in_array($propertyName, ['status', 'search', 'sortby'])) {
            $this->resetPage();
        }
    }
}
