<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\ManageCourseContent;

use Modules\Courses\Services\CourseService;
use Livewire\Component;
use Modules\Courses\Http\Requests\CourseAddSectionRequest;
use Modules\Courses\Jobs\UpdateCourseContentLength;
use Modules\Courses\Models\Course;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class CourseContent extends Component
{

    public $addSection = false;
    protected $allSections = [];
    public $editSection = null;
    public $tab;
    public $course_id;
    public $course;
    public $title;
    public $description;
    public $loading = false;

    public $per_page            = '';
    public $per_page_opt        = [];

    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        $this->tab          = request()->route('tab');
        $this->course_id    = request()->route('id');
        $this->course       = Course::findOrFail($this->course_id);
    }

    public function render()
    {
        $sections = (new CourseService())->getAllSections($this->course_id, setting('_general.per_page_record') ?? 15);

        $this->allSections = $sections;

        return view('courses::livewire.tutor.course-creation.components.manage-course-content.course-content', [
            'sections' => $sections,
        ]);
    }

    public function loadData() {}



    public function addSectionState($state = false)
    {
        $this->resetErrorBag();
        $this->addSection = $state;
        $this->dispatch('initEditor', target: '#section-desc', content: '');
    }

    public function createSection()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $data =  $this->validate((new CourseAddSectionRequest())->rules(), [], (new CourseAddSectionRequest())->attributes());
        $isCreated = (new CourseService())->createSection($data);
        if ($isCreated) {
            $this->dispatch('showAlertMessage', type: 'success', title: 'Section created successfully', message: 'Section created successfully');
            $this->reset(['title', 'description', 'addSection']);
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: 'Section not created', message: 'Section not created');
        }
    }

    public function deleteRecord($sectionId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $isDeleted = (new CourseService())->deleteSection((int) $sectionId);
        if ($isDeleted) {
            $this->dispatch('showAlertMessage', type: 'success', title: 'Section deleted successfully', message: 'Section deleted successfully');
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: 'Section not found', message: 'Section not found');
        }
    }

    public function editSectionFunction($section)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->resetErrorBag();
        $this->editSection = $section;
        $this->title = $section['title'];
        $this->description = $section['description'];
        $this->dispatch('initEditor', target: '#edit_section_description', content: $this->description, modal: '#edit-content');
    }

    public function updateSection()
    {
       
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $data = $this->validate((new CourseAddSectionRequest())->rules(), [], (new CourseAddSectionRequest())->attributes());
        (new CourseService())->updateSection($this->editSection['id'], $data);

        $this->dispatch('toggleEditorModal', target: '#edit-content', action: 'hide');
        $this->dispatch('showAlertMessage', type: 'success', title: 'Section updated successfully', message: 'Section updated successfully');
    }

    public function openDeleteModal($sectionId)
    {
        $this->setDeleteSection($sectionId);
        $this->dispatch('openDeleteModal');
    }
    public function openEditModal($section)
    {
        $this->editSectionFunction($section);
    }

    public function save()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        dispatch(new UpdateCourseContentLength(courseId: (int)$this->course_id));

        return redirect()->route('courses.tutor.edit-course', ['tab' => 'faqs', 'id' => $this->course_id]);
    }
}
