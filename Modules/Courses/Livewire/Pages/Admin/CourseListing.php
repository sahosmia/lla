<?php

namespace Modules\Courses\Livewire\Pages\Admin;

use App\Jobs\SendNotificationJob;
use Illuminate\Support\Facades\Auth;
use Modules\Courses\Services\CourseService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CourseListing extends Component
{
    use WithPagination;

    public $search = '';
    public $sortby = 'desc';
    public $status = '';
    public $user;
    public $underReviewStatus = '';
    private ?CourseService $courseService = null;

    public $filters = [
        'keyword'       => '',
        'status'        => '',
        'sort'          => 'desc'
    ];

    public $statuses = [
        'active',
        'need_revision',
        'under_review'
    ];


    public function boot()
    {
        $this->user = Auth::user();
        $this->courseService = new CourseService();
    }

    public function mount()
    {
        $this->filters['statuses'] = [
            'under_review',
            'need_revision',
            'active'
        ];
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $with       = ['category:id,name', 'subCategory:id,name', 'language:id,name', 'instructor.profile:id,user_id,first_name,last_name,verified_at'];
        $courses    = $this->courseService->getCourses(with: $with, filters: $this->filters);

        return view('courses::livewire.admin.course-listing', [
            'courses' => $courses
        ]);
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['status', 'search', 'sortby'])) {
            $this->resetPage();
        }
    }

    public function approveCourse($id)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $course = $this->courseService->getCourse(courseId: $id, relations: ['instructor.profile']);
        $this->courseService->updateCourseStatus($id, 'active');

        dispatch(new SendNotificationJob('courseApproved', $course->instructor, ['courseTitle' => $course->title, 'userName' => $course->instructor->profile->full_name]));

        $this->dispatch('showAlertMessage', type: 'success', message: __('courses::courses.course_approved_successfully'));
    }


    public function rejectCourse($id)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $course = $this->courseService->getCourse(courseId: $id, relations: ['instructor.profile']);

        $this->courseService->updateCourseStatus($id, 'need_revision');

        dispatch(new SendNotificationJob('courseRejected', $course->instructor, ['courseTitle' => $course->title, 'userName' => $course->instructor->profile->full_name]));

        $this->dispatch('showAlertMessage', type: 'success', message: __('courses::courses.course_rejected_successfully'));
    }

    #[On('delete-course')]
    public function deleteCourse($params){
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if(!empty($params['id'])){

            $course = $this->courseService->courseEnrollments($params['id']);
            if(!empty($course) && $course->enrollments->isNotEmpty()) {
                $this->dispatch('showAlertMessage',type: 'error',title: __('general.error_title') ,message: __('general.enrollments_exist')); 
                return;
            }
            $course = $this->courseService->deleteCourse($params['id']);
        } 
        if($course){
            $this->dispatch(
                'showAlertMessage',
                type: 'success',
                title: __('general.success_title') ,
                message: __('general.delete_record')
            );
        }
    }
}
