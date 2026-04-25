<?php

namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\ManageCourseContent\Components;

use Livewire\Attributes\Renderless;
use Modules\Courses\Http\Requests\CurriculumRequest;
use Modules\Courses\Services\CourseService;
use Livewire\Component;
use Modules\Courses\Services\CurriculumService;
use Livewire\WithFileUploads;
use App\Traits\PrepareForValidation;

class Curriculum extends Component
{
    use WithFileUploads, PrepareForValidation;

    public $section;
    public $key;
    public $title;
    public $description;
    public $addCurriculumState = false;
    public $isLoading = false;
    public $type = 'video';
    public $duration;
    public $yt_link;
    public $vm_link;
    public $mediaType = 'video';
    public $curriculumVideo;
    public $allowVideoFileExt = ['mp4'];
    public $videoFileSize = 2048;
    public $activeCurriculumItem = null;
    public $article_content;
    public $editCurriculumData = null;
    public $isCurriculumEditing = false;
    public $isDeletingCurriculum = false;
    public $curriculumId;

    public function mount($section)
    {
        $this->section = $section;
        $file_ext = !empty(setting('_general.allowed_video_extensions') ) ? setting('_general.allowed_video_extensions')  : 'mp4';
        $this->allowVideoFileExt = explode(',', $file_ext);
        $this->videoFileSize = !empty(setting('_general.max_video_size')) ? setting('_general.max_video_size') : 20;
    }

    public function render()
    {
        $curriculumItems = (new CurriculumService())->getAllCurriculums($this->section->id);
     
        return view('courses::livewire.tutor.course-creation.components.manage-course-content.components.curriculum', [
            'curriculumItems' => $curriculumItems,
        ]);
    }

    public function updateCurriculumType($type)
    {
        $this->activeCurriculumItem['type'] = $type;
        $this->dispatch('initEditor', target: '#curriculum_des_'.$this->section->id, content: $this->description);
    }

    public function updateCurriculumState($state = false)
    {
        $this->addCurriculumState = $state;
        $this->resetErrorBag();
        if ($state) {
            $this->updateActiveCurriculumItem(null);
            $this->dispatch('initEditor', target: '#curriculum_des_'.$this->section->id, content: $this->description);
        }
    }

    public function updateActiveCurriculumItem($curriculumItem = null)
    {
        $this->activeCurriculumItem = $curriculumItem;

        $this->yt_link = null;
        $this->vm_link = null;
        if ($curriculumItem != null) {
            if($curriculumItem['type'] === 'yt_link'){
                $this->yt_link = $curriculumItem['media_path'];
            }elseif($curriculumItem['type'] === 'vm_link'){
                $this->vm_link = $curriculumItem['media_path'];
            }
            $this->updateCurriculumState(false);
        }
    }

    public function addCurriculum()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $validatedData = $this->validate((new CurriculumRequest())->rules());

        $validatedData['section_id'] = $this->section->id;
        $validatedData['article_content'] = $this->article_content;
        $validatedData['media_path'] = null;
        $validatedData['thumbnail'] = null;
        $validatedData['type'] = $this->type;
        $curriculum = (new CurriculumService())->createCurriculum($validatedData);
        $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_created_successfully'), message: __('courses::courses.curriculum_created_successfully'));
        $this->addCurriculumState = false;
        $this->updateActiveCurriculumItem($curriculum->toArray());
        $this->resetErrorBag();
        $this->reset(['title', 'description', 'type', 'isCurriculumEditing']);
    }

    public function updatedActiveCurriculumItem($value, $key)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if(!empty($this->activeCurriculumItem['id']) && $key == 'is_preview'){
            $isUpdated = (new CurriculumService())->updateCurriculum($this->activeCurriculumItem['id'], ['is_preview' => $value]);
            if(!$isUpdated){
                 $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.curriculum_not_found'), message: __('courses::courses.curriculum_not_found'));
            } else {
                $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_updated_successfully'), message: __('courses::courses.curriculum_updated_successfully'));
            }
        }
    }

    public function rules(): array
    {
        return (new CurriculumRequest())->rules();
    }

    public function messages(): array
    {
        return (new CurriculumRequest())->messages();
    }

    public function updateCurriculum()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->beforeValidation();
        $validatedData = $this->validate($this->rules());
        
        $curriculum = (new CourseService())->updateCurriculum($this->editCurriculumData['id'], $validatedData);

        $this->reset(['title', 'description', 'type', 'isCurriculumEditing']);
        $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_updated_successfully'), message: __('courses::courses.curriculum_updated_successfully'));
        $this->dispatch('toggleEditorModal', target: '#edit-curriculum-'.$this->section->id, action: 'hide');
        $this->updateActiveCurriculumItem($curriculum->toArray());
    }

    public function deleteRecord($curriculumId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $isDeleted = (new CourseService())->deleteCurriculum((int)$curriculumId);
        if ($isDeleted) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_deleted_successfully'), message: __('courses::courses.curriculum_deleted_successfully'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.curriculum_not_found'), message: __('courses::courses.curriculum_not_found'));
        }
    }


    public function updatedCurriculumVideo(){
        $allowed_extensions = !empty(setting('_general.allowed_video_extensions')) 
        ? explode(',', setting('_general.allowed_video_extensions')) 
        : ['mp4']; 
        $max_size  = !empty(setting('_general.max_video_size')) ? setting('_general.max_video_size') : 20;

        $file_extension = $this->curriculumVideo->getClientOriginalExtension();
        $file_size = $this->curriculumVideo->getSize() / 1024 / 1024; 

        if (!in_array($file_extension, $allowed_extensions) || $file_size > $max_size) {
            $this->dispatch('showAlertMessage', type: 'error', message: __(
                'validation.invalid_file_type', 
                ['file_types' => implode(', ', $allowed_extensions)]
            ));
            $this->curriculumVideo = null;
            return;
        }
    }


    public function updateCurriculumContent()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }  
        if ($this->activeCurriculumItem['type'] == 'video' ) {
            if ($this->curriculumVideo) {
                if ($this->curriculumVideo instanceof \Illuminate\Http\UploadedFile) { 
                    $fileName    = uniqueFileName('public/curriculum_videos', $this->curriculumVideo->getClientOriginalName());
                    $curriculumVideo = $this->curriculumVideo->storeAs('curriculum_videos', $fileName, getStorageDisk());
                    $this->curriculumVideo = $curriculumVideo;
                }
                
                $curriculum = (new CurriculumService())->updateCurriculum(
                    $this->activeCurriculumItem['id'], 
                    [
                        'media_path'        => $this->curriculumVideo, 
                        'type'              => 'video', 
                        'content_length'    => $this->duration,
                        'is_preview'        => !empty($this->activeCurriculumItem['is_preview']) ? $this->activeCurriculumItem['is_preview'] : false
                    ]);
                $this->updateActiveCurriculumItem($curriculum->toArray());
                $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_updated_successfully'), message: __('courses::courses.curriculum_updated_successfully'));
            } else {
                $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.please_add_a_video'), message: __('courses::courses.please_add_a_video'));
            }
        } elseif($this->activeCurriculumItem['type'] == 'yt_link' ) {
            
            $this->validate([
                'yt_link' => [
                    'required',
                    'url',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[a-zA-Z0-9_-]+$/', $value)) {
                            $fail('Please enter a valid YouTube video link.');
                        }
                    },
                ],
            ], [
                'yt_link.required' => 'Please enter a YouTube link.',
                'yt_link.url' => 'Please enter a valid URL.',
            ]);
            
           
            $curriculum = (new CurriculumService())->updateCurriculum(
                $this->activeCurriculumItem['id'],
                [
                    'media_path'        => $this->yt_link,
                    'type'              => $this->activeCurriculumItem['type'],
                    'content_length'    => $this->duration,
                    'is_preview'        => !empty($this->activeCurriculumItem['is_preview']) ? $this->activeCurriculumItem['is_preview'] : false,
                ]
            );    
            $this->updateActiveCurriculumItem($curriculum->toArray());
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_updated_successfully'), message: __('courses::courses.curriculum_updated_successfully'));
        } elseif($this->activeCurriculumItem['type'] == 'vm_link'){
            $this->validate([
                'vm_link' => 'required|url',
            ],[
                'vm_link.required' => 'Please enter a valid Vimeo link',
                'vm_link.url' => 'Please enter a valid Vimeo link',
            ]);
            $curriculum = (new CurriculumService())->updateCurriculum(
                $this->activeCurriculumItem['id'],
                [
                    'media_path'        => $this->vm_link,
                    'type'              => $this->activeCurriculumItem['type'],
                    'content_length'    => $this->duration,
                    'is_preview'        => !empty($this->activeCurriculumItem['is_preview']) ? $this->activeCurriculumItem['is_preview'] : false,
                ]
            );    
            $this->updateActiveCurriculumItem($curriculum->toArray());
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_updated_successfully'), message: __('courses::courses.curriculum_updated_successfully'));
        }  else {
            $this->validate([
                'article_content' => 'required|string'
            ]);
            $content = strip_tags($this->article_content);
            $wordCount = str_word_count($content);
            $totalMinutes = ceil($wordCount / 238);
            $duration = 0;
            if($totalMinutes > 0){
                $duration = $totalMinutes * 60;
            }
            
            $curriculum = (new CurriculumService())->updateCurriculum(
                $this->activeCurriculumItem['id'], 
                [
                    'article_content'   => $this->article_content, 
                    'type'              => 'article', 
                    'content_length'    => $duration,
                    'is_preview' => !empty($this->activeCurriculumItem['is_preview']) ? $this->activeCurriculumItem['is_preview'] : false
                ]
            );
            $this->updateActiveCurriculumItem($curriculum->toArray());
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_updated_successfully'), message: __('courses::courses.curriculum_updated_successfully'));
        }
    }

    public function removeCurriculumContent()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if ($this->curriculumVideo) {
            $this->curriculumVideo = null;
        }
        if ($this->yt_link) {
            $this->yt_link = null;
        }
        if ($this->vm_link) {
            $this->vm_link = null;
        }

        $curriculum = (new CurriculumService())->updateCurriculum($this->activeCurriculumItem['id'], ['media_path' => null]);
        $this->updateActiveCurriculumItem($curriculum->toArray());
        $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.curriculum_updated_successfully'), message: __('courses::courses.curriculum_updated_successfully'));
    }

    public function editCurriculumModal($curriculum)
    {   
        $this->resetErrorBag();
        $this->title = $curriculum['title'];
        $this->description = $curriculum['description'];
        $this->editCurriculumData = $curriculum;
        $this->dispatch('initEditor', target: '#edit_curriculum_des_'.$this->section->id, content: $curriculum['description'], modal: '#edit-curriculum-'.$this->section->id);
    }

    public function updateCurriculumOrder($list)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        (new CurriculumService())->sortCurriculumItems($list, $this->section->id);
    }
}
