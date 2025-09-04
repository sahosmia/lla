<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components;

use Illuminate\Support\Facades\Log;
use Modules\Courses\Http\Requests\CourseFaqsRequest;
use Modules\Courses\Http\Requests\CoursePrerequisitesRequest;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;
use Livewire\Component;
use Livewire\Attributes\On;

class CourseFaqs extends Component {

    public $courseId;
    public $course;

    public $faqs;
    public $prerequisites   = null;
    public $question        = null;
    public $answer          = null;
    public $editFaqId       = null;
    public $updateMode      = false;
    public $enablePromotion = false;

    public function mount() {
        $this->courseId         = request()->route('id');
        $this->course           = Course::with(['faqs', 'pricing:id,course_id,final_price'])->findOrFail($this->courseId);
        if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && !empty(intval($this->course?->pricing?->final_price ?? 0))) {
            $this->enablePromotion = true;
        }
        $this->prerequisites    = $this->course->prerequisites;
        $this->faqs             = $this->course->faqs;
        $this->dispatch('loadPageJs');
    }

    public function render() {
        return view('courses::livewire.tutor.course-creation.components.course-faqs');
    }

    public function loadData() {
    }

    public function editFaq($faq) {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->resetErrorBag();
        $this->editFaqId    = $faq['id'];
        $this->question     = $faq['question'];
        $this->answer       = $faq['answer'];
        $this->dispatch('toggleModel', id: 'create-faq', action: 'show');
        $this->dispatch('initializeSummernote');
        $this->updateMode   = true;
    }

    public function addMoreFaq() {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->resetErrorBag();
        $this->dispatch('toggleModel', id: 'create-faq', action: 'show');
        $this->dispatch('initializeSummernote');
        $this->reset(['question', 'answer', 'editFaqId', 'updateMode']);
        $this->updateMode   = false;
    }

    public function addFaq() {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $validatedFaqs = $this->validate((new CourseFaqsRequest())->rules());
        try {
            if ($this->editFaqId) {
                (new CourseService())->updateCourseFaq($this->course, $this->editFaqId, $validatedFaqs);
            } else {
                (new CourseService())->addCourseFaq($this->course, $validatedFaqs);
            }
            $this->faqs = $this->course->faqs()->get();
            $this->reset(['question', 'answer']);
            $this->dispatch('toggleModel', id: 'create-faq', action: 'hide');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public function save() {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $validatedPrerequisites = $this->validate((new CoursePrerequisitesRequest())->rules());
        $coursePrerequisites = (new CourseService())->updatePrerequisites($this->courseId, $validatedPrerequisites['prerequisites']);

        $tab = 'noticeboard';
        if($this->enablePromotion){
            $tab = 'promotions';
        }
        
        return redirect()->route('courses.tutor.edit-course', ['tab' => $tab, 'id' => $coursePrerequisites->id]);
    }

    #[On('delete-faq')]
    public function deleteFaq($params = []) {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $deleted = (new CourseService())->deleteFaq($this->course, $params['id']);
        if ($deleted) {
            $this->faqs = $this->course->faqs()->get();
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.faq_deleted'), message: __('courses::courses.faq_deleted_successfully'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error_title'), message: __('courses::courses.faq_delete_failed'));
        }
    }
}
