<?php

namespace Modules\Courses\Livewire\Pages\Student\CourseList;

use Modules\Courses\Models\Like;
use Modules\Courses\Services\CourseService;
use Illuminate\Support\Facades\Auth;
use Modules\Courses\Models\Course;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CourseList extends Component
{
    use WithPagination;
    
    // public $course;
    public $logo;

    
    public $slug;
    public $rating;
    public $description;
    public $isLoading = true;
    public $progress;
    public $studentRating;
    public $perPage;
    public $showClearFilters = false;

  
    public $languages;
    public $levels;
    public $categories;
    public $totalCourses;
    public $paidCourses;
    public $searchCategories    = [];
    public $searchLanguages     = [];
    public $ratingCounts        = [];
    public $durationCounts      = [];
    public $priceTypeCounts     = [];
    public $currentVideo = null;
    public $parPageList = [10, 20, 30, 40, 50];
    public $keyword           = '';
    public $filters     = [
        'sort'              => 'desc',
    ];

    public function mount() {
        $this->perPage  = 9;
       
    }

    #[Computed]
    public function courses(){
        $courses = (new CourseService())->getAllEnrolledCourses(
            keyword: $this->keyword,
            withSum: [
                'courseProgress' => 'duration'
            ],
            studentId: Auth::id(),
        );

        return $courses;
    }

    public function loadCourseData() {}

    #[Layout('layouts.app')]
    public function render()
    {
        $courses = $this->courses;
        $favCourseIds = Like::where('likeable_type', Course::class)->where('user_id', Auth::id())?->pluck('likeable_id')?->toArray() ?? [];
        return view('courses::livewire.student.course-list.courselist', compact('courses', 'favCourseIds'));
    }

    public function loadCoursesData() {
        $this->isLoading = false;
    }

    public function likeCourse($courseId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $course = (new CourseService())->getCourse($courseId);

        if ($this->isLiked($course)) {
            $course->likes()->where('user_id', Auth::id())->delete();
        } else {
            $course->likes()->create([
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function isLiked($course)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        return $course->likes()->where('user_id', Auth::id())->exists();
    }
}
