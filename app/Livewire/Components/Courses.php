<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;
use Modules\Courses\Models\Like;
use Illuminate\Support\Facades\Auth;

class Courses extends Component
{
    public $sectionVerient;
    public $coursesLimit;

    public function mount($sectionVerient, $coursesLimit)
    {
        $this->sectionVerient   = $sectionVerient;
        $this->coursesLimit     = $coursesLimit;
    }

    public static function hasCourses()
    {
        return Course::exists();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $courses = $this->getFeaturedCourses();
        $courses->each(function ($course) {
            $course->like_user_ids = $course->likes->pluck('user_id');
        });
        return view('livewire.components.courses', compact('courses'));
    }

    public function getFeaturedCourses()
    {
        return Course::with([
            'category',
            'pricing',
            'language',
            'promotionalVideo',
            'instructor',
            'instructor.profile',
            'likes',
            'thumbnail',
            'curriculums',
        ])->whereStatus(Course::STATUSES['active'])->limit($this->coursesLimit)->get();
    }

    public function likeCourse($courseId)
    {
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
        return $course->likes()->where('user_id', Auth::id())->exists();
    }
}
