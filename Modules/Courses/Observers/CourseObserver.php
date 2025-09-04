<?php

namespace Modules\Courses\Observers;

use Modules\Courses\Models\Course;
use Illuminate\Support\Str;

class CourseObserver
{
    /**
     * Handle the Course "creating" event.
     *
     * @param  \Modules\Courses\Models\Course  $course
     * @return void
     */
    public function created(Course $course)
    {
        $slug            = Str::slug($course->title);
        $course->slug    = $this->uniqueSlug($slug, $course);

        $course->save();
    }

    /**
     * Create unique slug automatically
     * @return string unique slug
     */
    protected function uniqueSlug($slug, $course)
    {
        if (Course::whereSlug($slug)->whereNot('id', $course->id)->exists()) {
            $slug = $slug . "-" . $course->id;
        }
        return $slug;
    }

    /**
     * Listen to the Course updated event.
     *
     * @param  \Modules\Courses\Models\Course $course
     * @return void
     */
    public function updated(Course $course): void {}
}
