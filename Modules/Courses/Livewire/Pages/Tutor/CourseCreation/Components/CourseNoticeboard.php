<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use Modules\Courses\Http\Requests\CoursePromotionRequest;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;
use Livewire\Attributes\On;

class CourseNoticeboard extends Component
{
    public $courseId;
    public $course;
    public $content;
    public $noticeboardId;
    public $backRoute;

    public function mount()
    {
        

        $this->courseId         = request()->route('id');
    }

    public function render()
    {
        $course = Course::with('noticeboards', 'pricing')->findOrFail($this->courseId);
        if(!empty($course?->pricing?->final_price) && $course?->pricing?->final_price > 0 && \Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')){
            $this->backRoute = route('courses.tutor.edit-course', ['tab' => 'promotions', 'id' => $this->courseId]);
        } else {
            $this->backRoute = route('courses.tutor.edit-course', ['tab' => 'faqs', 'id' => $this->courseId]);
        }

        $noticeboards       = $course?->noticeboards ?? collect();
        return view('courses::livewire.tutor.course-creation.components.course-noticeboard', compact('noticeboards','course'));
    }

    public function updateNoticeboard()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        try {
            $validatedData = $this->validate([
                'content' => 'required|string|max:65535',
            ]);
         
          
            $validatedData['id'] = $this->noticeboardId;
            $validatedData['course_id'] = $this->courseId;
            $isUpdated = (new CourseService())->updateCourseNoticeboard($validatedData);

            if($isUpdated) {
                $this->dispatch('showAlertMessage', type: 'success', title: '', message: $this->noticeboardId ? __('courses::courses.noticeboard_updated') : __('courses::courses.noticeboard_created'));
                $this->dispatch('updateContent', content: '');
                $this->reset(['content']);
            }
        } catch (ValidationException $e) {
            throw $e;
        }
    }


    #[On('delete-noticeboard')]
    public function deleteNoticeBoard($params = [])
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $deleted = (new CourseService())->deleteNoticeboard($params['id']);
        if ($deleted) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.noticeboard_deleted'), message: __('courses::courses.noticeboard_deleted_success'));
            $this->dispatch('toggleModel', id: 'create-promotion', action: 'hide');
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error'), message: __('courses::courses.noticeboard_delete_failed'));
        }
    }

    public function editNoticeboard($id)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $noticeboard = (new CourseService())->getNoticeboardById($id, $this->courseId);
        $this->noticeboardId = $id;
        $this->content = $noticeboard->content;
        $this->dispatch('updateContent', content: $this->content);
    }

    public function save()
    {
        if(\Nwidart\Modules\Facades\Module::has('forumwise') && \Nwidart\Modules\Facades\Module::isEnabled('forumwise')){
            $route = route('courses.tutor.edit-course', ['tab' => 'discussion-forum', 'id' => $this->courseId]);
            return redirect($route);
        }

        $course = Course::find($this->courseId);
        if($course->status != 'draft' && $course->status != 'need_revision') {
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.course_updated'), message: __('courses::courses.course_updated_successfully'));
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
