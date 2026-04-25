<?php

namespace Modules\Courses\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;

class UpdateCourseContentLength implements ShouldQueue
{
    use Queueable;

    protected int $courseId;
    protected Course $course;
    /**
     * Create a new job instance.
     */
    public function __construct(int $courseId)
    {
        $this->courseId = $courseId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!empty($this->courseId)) {
            $this->course   = (new CourseService())->getCourse(courseId: $this->courseId, relations: ['sections.curriculums']);

            if (!empty($this->course)) {

                $totalContentLength = $this->course->sections->sum(function ($section) {
                    return $section->curriculums->sum('content_length');
                });

                if ($totalContentLength > 0) {
                    $this->course->content_length    = $totalContentLength;
                    $this->course->save();
                }
            }
        }
    }
}
