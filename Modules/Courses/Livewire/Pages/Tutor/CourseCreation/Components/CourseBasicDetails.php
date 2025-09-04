<?php

namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components;

use App\Models\Language;
use App\Traits\PrepareForValidation;
use Illuminate\Support\Facades\Auth;
use Modules\Courses\Http\Requests\CourseBasicDetailRequest;
use Modules\Courses\Models\Category;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;
use Livewire\Component;
use App\Jobs\GenerateCertificateJob;
class CourseBasicDetails extends Component
{
    use PrepareForValidation;
    public $courseId = null;
    public $course;
    public $title;
    public $description;
    public $subtitle;
    public $category_id;
    public $sub_category_id;
    public $tags = [];
    public $type;
    public $level;
    public $language_id;
    public $categories;
    public $languages;
    public $levels;
    public $types;
    public $sub_categories         = [];
    public $learning_objectives    = [''];
    public $templates = [];
    public $template_id = '';
    public $assign_quiz_certificate = 'any';
    public function mount()
    {
        $this->courseId = request()->route('id');
   
        $this->categories   = Category::whereParentId(null)->whereNull('deleted_at')->get();
        $this->languages    = Language::all();
        $this->levels       = Course::LEVEL;
        $this->types        = [
            'video'             => 1,
            'live'              => 3,
            'article'           => 4,
            'all'               => 5,
        ];

        if ($this->courseId) {
            $this->loadCourseData();
        }

        if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify')){
            $this->templates = get_templates();
        }
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    public function loadData()
    {
        $this->dispatch('loadPageJs');
    }

    public function loadCourseData()
    {
        $course = (new CourseService())->getCourse(courseId: $this->courseId, instructorId: Auth::id());

        if (!$course) {
            abort(404);
        }

        $this->sub_categories           = Category::whereParentId($course->category_id)->get();
        $this->title                    = $course->title;
        $this->description              = $course->description;
        $this->subtitle                 = $course->subtitle;
        $this->category_id              = $course->category_id;
        $this->sub_category_id          = $course->sub_category_id;
        $this->tags                     = $course->tags;
        $this->type                     = $course->type;
        $this->level                    = $course->level;
        $this->language_id              = $course->language_id;
        $this->template_id              = $course?->certificate_id ?? '';
        $this->assign_quiz_certificate  = !empty($course?->meta_data['assign_quiz_certificate']) ? $course?->meta_data['assign_quiz_certificate'] : 'any';
        $this->learning_objectives      = !empty($course->learning_objectives) ?  $course->learning_objectives : [''];
        
    }

    private function rules()
    {
        return (new CourseBasicDetailRequest())->rules();
    }

    public function createOrUpdateCourse()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        try {
            $this->beforeValidation(['tags', 'learning_objectives']);
            $validatedData = $this->validate((new CourseBasicDetailRequest())->rules(), [], (new CourseBasicDetailRequest())->attributes());

            if (!empty($this->template_id)) {
                $validatedData['certificate_id'] = $this->template_id;
            }
            if(isActiveModule('upcertify') && isActiveModule('quiz')){
                $validatedData['meta_data'] =  array('assign_quiz_certificate' => $this->assign_quiz_certificate);
            }
            // Sanitize learning objectives
            $this->learning_objectives              = SanitizeArray($this->learning_objectives);
            $validatedData['learning_objectives']   = array_filter($this->learning_objectives, fn($objective) => !empty($objective));

            // Sanitize tags
            $this->tags             = SanitizeArray($this->tags);
            $validatedData['tags']  = array_filter($this->tags, fn($tag) => !empty($tag));

            $validatedData['instructor_id'] = Auth::id();

            $course = (new CourseService())->updateOrCreateCourse($this->courseId, $validatedData);
            return redirect()->route('courses.tutor.edit-course', ['tab' => 'media', 'id' => $course->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('loadPageJs');
            throw $e;
        }
    }

    public function render()
    {

        return view('courses::livewire.tutor.course-creation.components.course-details');
    }

    public function updatedCategoryId()
    {
        $this->sub_categories = Category::whereParentId($this->category_id)->get();
        $this->dispatch('sub-categories-updated', sub_categories: $this->sub_categories);
    }
    public function updatedSubCategoryId()
    {
        $this->dispatch('loadPageJs');
    }

    public function addLearningObjective()
    {
        array_unshift($this->learning_objectives, '');
        $this->dispatch('loadPageJs');
    }

    public function removeLearningObjective($index)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        unset($this->learning_objectives[$index]);
        $this->learning_objectives = array_values($this->learning_objectives);

        $this->dispatch('loadPageJs');
    }

    public function updateLearningObjectivePosition($list)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $sortedLearningObjectives = [];
        if (!empty($list)) {

            foreach ($list as $item) {
                $sortedLearningObjectives[] = $this->learning_objectives[$item['value']];
            }

            $this->learning_objectives = $sortedLearningObjectives;
        }
    }

    
}
