<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;

class CourseDiscussionForum extends Component
{
    public $courseId;
    public $course;
    public $enableDiscussionForum = false;
 


    public function mount()
    {
        $this->courseId         = request()->route('id');
        $this->course           = Course::findOrFail($this->courseId);
        $this->enableDiscussionForum = $this->course->discussion_forum;
        if(!\Nwidart\Modules\Facades\Module::has('forumwise') || !\Nwidart\Modules\Facades\Module::isEnabled('forumwise')){
            abort(404);
        }
    }

    public function updatedEnableDiscussionForum()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $isUpdated = $this->course->update(['discussion_forum' => $this->enableDiscussionForum]);
        if($isUpdated) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.success'), message: __('courses::courses.discussion_forum_updated'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error'), message: __('courses::courses.discussion_forum_update_failed'));
        }
    }

    public function render()
    {
        return view('courses::livewire.tutor.course-creation.components.course-discussion-forum');
    }


    public function save()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if($this->course->status != 'draft' && $this->course->status != 'need_revision') {
            return redirect()->route('courses.tutor.courses');
        }

        DB::beginTransaction();

        try {
            (new CourseService())->updateOrCreateCourse($this->courseId, ['status' => 'under_review']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error'), message: __('courses::courses.discussion_forum_update_failed'));
        }

        return redirect()->route('courses.tutor.edit-course', ['tab' => 'publish', 'id' => $this->courseId]);
    }
}
