<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components;

use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Modules\Courses\Http\Requests\CourseMediaRequest;

class CourseMedia extends Component
{
    use WithFileUploads;

    public $courseId;
    public $course;
    public $coursePromotionalVideo;

    public $thumbnail;
    public $promotionalVideo;

    public $imageExtensions;
    public $videoExtensions;
    public $imageSize           = '';
    public $videoSize           = '';
    public $isBase64 = false;
    public $imageName;
    public $thumbnailError = false;
    public $thumbnailErrorMessage = '';

    public $thumbnailSize = 0;
    public $uploadedThumbnailSize = 0;

    public $promotionalVideoSize = 0;
    public $uploadedPromotionalVideoSize = 0;

    public function mount()
    {
        $this->courseId     = request()->route('id');
        $this->course       = Course::with(['thumbnail', 'promotionalVideo'])->findOrFail($this->courseId);
        $this->thumbnail    = $this->course?->thumbnail ? $this->course?->thumbnail?->path : null;
        if ($this->thumbnail) {
            $thumbnailPath = storage_path('app/public/' . $this->thumbnail);
            if (file_exists($thumbnailPath)) {
                $this->thumbnailSize = filesize($thumbnailPath);
                $this->thumbnailSize = (round($this->thumbnailSize / 1000, 2));
            } else {
                $this->thumbnailSize = 0;
            }
        } else {
            $this->thumbnailSize = 0;
        }

        $this->coursePromotionalVideo   = $this->course->promotionalVideo;

        if ($this->coursePromotionalVideo) {
            $videoPath = storage_path('app/public/' . $this->course->promotionalVideo->path);
            if (file_exists($videoPath)) {
                $this->promotionalVideoSize = filesize($videoPath);
                $this->promotionalVideoSize = (round($this->promotionalVideoSize / (1024 * 1024), 2));
            } else {
                $this->promotionalVideoSize = 0;
            }
        } else {
            $this->promotionalVideoSize = 0;
        }
        
        $this->imageExtensions      = setting('_general.allowed_image_extensions');
        $this->videoExtensions      = setting('_general.allowed_video_extensions');
        $this->imageSize            = (int)(setting('_general.max_image_size')??1) * 1024;
        $this->videoSize            = (int)(setting('_general.max_video_size')??1) * 1024;
    }

    public function render()
    {
        return view('courses::livewire.tutor.course-creation.components.course-media');
    }

    public function updatedThumbnail()
    {
        if ($this->thumbnail) {
            $this->validate([
                'thumbnail' => "required|regex:/^data:image\/[a-zA-Z]+;base64,/|string",
            ]);
        }
    }

    public function updatedPromotionalVideo()
    {
        if ($this->promotionalVideo) {
            $this->validate([
                'promotionalVideo' => 'required|mimes:' . $this->videoExtensions . '|max:' . $this->videoSize,
            ], [
                'promotionalVideo.max' => __('courses::courses.promotional_video_max', ['max' => round($this->videoSize / 1024)]),
            ]);

            $this->coursePromotionalVideo = '';

            $this->uploadedPromotionalVideoSize = round($this->promotionalVideo->getSize() / (1024 * 1024), 2);
        }
    }

    public function removeMedia($type)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if ($type == 'thumbnail') {
            $this->thumbnail = null;

            if ($this->course->thumbnail) {
                $thumbnailPath = storage_path('app/public/' . $this->course->thumbnail->path);
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }
                $this->course->thumbnail->delete();

                $this->resetErrorBag('thumbnail');
            }
            $this->course->refresh();
        } elseif ($type == 'video') {
            $this->promotionalVideo = null;
            $this->coursePromotionalVideo = '';

            if ($this->course?->promotionalVideo?->path) {
                $videoPath = storage_path('app/public/' . $this->course->promotionalVideo?->path);
                if (file_exists($videoPath)) {
                    unlink($videoPath);
                }

                $this->course->promotionalVideo->delete();

                $this->resetErrorBag('promotionalVideo');
            }

            $this->course->refresh();
        }
    }

    public function loadData() {}

    public function clearValidationErrors($type)
    {
        $this->resetErrorBag($type);
    }



    public function store()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->thumbnailError = false;
        $this->thumbnailErrorMessage = '';

        // Adjust validation rules to make promotionalVideo and thumbnail nullable if they already exist
        $rules = (new CourseMediaRequest())->rules();
        if ($this->coursePromotionalVideo) {
            $rules['promotionalVideo'] = 'nullable|mimes:' . $this->videoExtensions . '|max:' . $this->videoSize;
        }

        $this->validate($rules, (new CourseMediaRequest())->messages(), (new CourseMediaRequest())->attributes());
        if (!empty($this->thumbnail) && !empty($this->isBase64)) {
            $thumbnailPath = null;
            $bse64 = explode(',', $this->thumbnail);
            $bse64 = trim($bse64[1]);
            if (base64_encode(base64_decode($bse64, true)) === $bse64) {
                $randomName = Str::random(40);
                $thumbnailPath = uploadBase64Image('media/thumbnails', $randomName, $this->thumbnail);
            }
            $this->isBase64 = false;
            if ($thumbnailPath) {
                (new CourseService)->addCourseMedia($this->course, [
                    'mediable_id'       => $this->courseId,
                    'mediable_type'     => Course::class,
                    'type'              => 'thumbnail',
                ], [
                    'path'              => $thumbnailPath,
                ]);
            }
        }

        if ($this->promotionalVideo) {
            $videoPath = $this->promotionalVideo->store('media/videos', getStorageDisk());
            (new CourseService)->addCourseMedia($this->course, [
                'mediable_id'       => $this->courseId,
                'mediable_type'     => 'course',
                'type'              => 'promotional_video',
            ], [
                'path'              => $videoPath,
            ]);
        }

       if(isPaidSystem()){ 
        $tab = 'pricing';
       }else{
        $tab = 'content';
       }
        
        return redirect()->route('courses.tutor.edit-course', ['tab' => $tab, 'id' => $this->courseId]);
    }
}
