<?php


namespace Modules\Upcertify\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\Upcertify\Models\Media;
use Illuminate\Support\Facades\Storage;
use Modules\Upcertify\Models\Template;

class CreateCertificate extends Component {
    use WithFileUploads;
    
    #[Url] 
    public $tab = 'general';

    #[Url]
    public $as_template = false;

    public $isEdit = false;
    public $id = null;
    public $thumbnail_url;
    public $templates;
    public $title;
    public $attachments;
    public $backgrounds;
    public $shapeIcons;
    public $badeIcons;
    public $patterns;
    public $frames;
    public $media;
    public $media_type = 'media';
    public $media_title;
    public $search = '';
    public $allowFileExt=['jpg','jpeg','png','gif'];
    public $fileSize = 10240;
    public $loadingBackgrounds = false;
    public $loadingPattern = false;

    public $loadingAttachments = false;
    public $loadingTemplates = false;
    public $canvasImage;
    public $fonts = [];
    public $body;
    public $certificate;
    public $wildcards = [];

    public function mount($record_id = null) {
        $this->wildcards = config('upcertify.wildcards') ?? [];
        $this->wildcards[] = 'custom_message';

        if(!in_array($this->tab, ['general', 'media', 'templates', 'elements','library','background'])){
            $this->tab = 'general';
        }

        if(!empty($record_id)) {
            $certificate = Template::whereKey($record_id)->whereNotNull('user_id')->first();
            if($certificate && ($certificate->user_id == Auth::id() || empty($certificate->user_id))) {
                $this->id = $certificate->id;
                $this->title = $certificate->title;
                $this->body = $certificate->body;
                $this->thumbnail_url = $certificate->thumbnail_url;
                $this->isEdit = true;
            } else {
                abort(404);
            } 
        } else {
            abort(404);
        }
        
        if ($this->tab == 'media') {
            $this->getBackgrounds();
        }
        
        if($this->tab == 'templates') {
            $this->getTemplates();
        }
        if($this->tab == 'background') {
            $this->getPattern();
        }
        // if($this->tab == 'library') {
        //     $this->getAttachment();
        // }
        $this->fonts = $this->getGoogleFonts();
    }

    public function activeTab($tab) {
        $this->media_type = $tab;
    }

    public function createNow() {
       
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        $whare = ['id' => empty($this->as_template) ? $this->id : null,  'user_id' => Auth::id()];

        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showToast', 
               type: 'error',
               message: __('general.demosite_res_txt')
            );
            return;
        }

        $certificate = Template::updateOrCreate(
            $whare,
            [
                'title' => $this->title, 
                'user_id' => Auth::id(), 
                'status' => 'publish',
                'thumbnail_url' => $this->thumbnail_url,
                'body' => $this->body,
            ]
        );


        if($certificate){
            $this->dispatch('showToast', type: 'success', message: __('upcertify::upcertify.certificate_title_updated'));
            sleep(1);
            $url = route('upcertify.certificate-list');
            return redirect($url);
        }
    }
    public function resetErrors($field = null)
    {
        $this->reset('media');
        $this->reset('media_title');     
        $this->resetErrorBag($field);

    }

    public function updatedMedia() {
        $this->validate([
            'media' => 'mimes:' . implode(',', $this->allowFileExt) . '|max:' . $this->fileSize, // Max size in KB
        ]);
    }

    public function removeMedia() {
        $this->media = null;
    }
    
    public function updateTab($tab){

        $this->search = '';
        if($this->id && in_array($tab, ['general', 'media', 'templates', 'elements','library','background'])) {
            $this->tab = $tab;
            if($tab == 'templates' && (empty($this->templates) || $this->templates->isEmpty())) {
                $this->getTemplates();
            }
            if($tab == 'media' && (empty($this->backgrounds) || $this->backgrounds->isEmpty())) {
                $this->getBackgrounds();
            }
            // if($tab == 'library' && empty($this->attachments)) {
            //     $this->getAttachment();
            // }
            if($tab == 'background' && empty($this->patterns)) {
                $this->getPattern();
            }
        }
    }

    // public function getAttachment() {
    //     $this->loadingAttachments = true;
    //     $this->attachments = Media::where('type', Media::TYPE['attachment'])->orderBy('id', 'desc')->get();
    //     $this->loadingAttachments = false;
    // }

    public function updatedSearch(){
        if($this->tab == 'templates'){

            $this->getTemplates();
        } elseif($this->tab == 'media') {
            $this->getBackgrounds();
        }
    }

    public function getTemplates() {

        $this->loadingTemplates = true;
        $this->templates = Template::select('id','title','thumbnail_url')->whereNull('user_id')->when($this->search, function($query, $search){
            return $query->where('title', 'like', '%'.$search.'%');
        })
        ->orderBy('id', 'desc')->get();
        $this->loadingTemplates = false;
    }

    public function getBackgrounds() {
        $this->loadingBackgrounds = true;
        $this->backgrounds = Media::where('type', Media::TYPE['media'])->when($this->search, function($query, $search){
            return $query->where('title', 'like', '%'.$search.'%');
        })
        ->orderBy('id', 'desc')->get();
        $this->loadingBackgrounds = false;
    }
    public function getPattern() {
        $this->loadingPattern = true;
        $this->patterns = Media::where('type', Media::TYPE['pattern'])->orderBy('id', 'desc')->get();
        $this->loadingPattern = false;
    }
    
    public function deleteTemplate($id) {
        $certificate = Template::find($id);
        
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showToast', 
               type: 'error',
               message: __('general.demosite_res_txt')
            );
            return;
        }

        if($certificate) {
            $certificate->delete();
            $this->templates = $this->templates->reject(function($item) use ($id) {
                return $item->id == $id;
            });
            $this->dispatch('showToast', type: 'success', message: 'Template deleted successfully');
        }
    }

    public function useAsTemplate($id) {

        $certificate = Template::find($id);
        if($certificate) {
            $body = $certificate->body;
            $renderedHtml = view('upcertify::components.body', ['body' => $body])->render();
            $this->dispatch('embedTemplate', template: $renderedHtml);

        }
    }

    public function useAsShapeIcons() {

            $shapeIcons = [
                'ellipse',
                'hexagon',
                'octagon',
                'parallelogram',
                'rectangle',
                'star',
                'triangle',
                'vector',
            ];
            foreach ($shapeIcons as $shape) {
                $componentClass = 'upcertify::components.shaps.' . Str::kebab($shape); 
                $this->shapeIcons[$shape] = view($componentClass)->render();
            }
            $this->shapeIcons[$shape] = view($componentClass)->render();
    }

    public function useAsBadeIcons() {
       $badeIcons = [
            'artboard01',
            'artboard02',
            'artboard03',
            'artboard04',
            'artboard05',
            'artboard06',
            'artboard07',
            'artboard08',
            'artboard09',
            'artboard10',
        ];
        foreach ($badeIcons as $shape) {
            $componentClass = 'upcertify::components.badges.' . Str::kebab($shape); 
            $this->badeIcons[$shape] = view($componentClass)->render();
        }
        $this->badeIcons[$shape] = view($componentClass)->render();
    }

    public function useAsAttachments() {
        $attachments = [
             'attachment-1',
             'attachment-2',
             'attachment-3',
             'attachment-4',
             'attachment-5',
         ];
         foreach ($attachments as $attachment) {
             $componentClass = 'upcertify::components.attachments.' . Str::kebab($attachment); 
             $this->attachments[$attachment] = view($componentClass)->render();
         }
         $this->attachments[$attachment] = view($componentClass)->render();
     }

     public function useAsFrames() {
        $frames = [
            'frame-1' => [
                'icon',
                'thumbnail',
            ],
            'frame-2' => [
                'icon',
                'thumbnail',
            ],
            'frame-3' => [
                'icon',
                'thumbnail',
            ],
            'frame-4' => [
                'icon',
                'thumbnail',
            ],
            'frame-5' => [
                'icon',
                'thumbnail',
            ],
        ];
        $this->frames = [];
        foreach ($frames as $key => $frame) {
            foreach ($frame as $value) {
                if ($value === 'icon') {
                    $componentClass = 'upcertify::components.frames.icons.' . Str::kebab($key);
                } else {
                    $componentClass = 'upcertify::components.frames.thumbnail.' . Str::kebab($key);
                }
                $this->frames[$key][$value] = view($componentClass)->render();
            }
        }
    }
     
    public function deleteMedia($id) {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showToast', 
               type: 'error',
               message: __('general.demosite_res_txt')
            );
            return;
        }
        $media = Media::find($id);
        if($media) {
            $media->delete();
            if($media->type == 'media') {
                $this->backgrounds = $this->backgrounds->reject(function($item) use ($id) {
                    return $item->id == $id;
                });
            } else if($media->type == 'pattern') {
                $this->patterns = $this->patterns->reject(function($item) use ($id) {
                    return $item->id == $id;
                });
            }
            // else {
            //     $this->attachments = $this->attachments->reject(function($item) use ($id) {
            //         return $item->id == $id;
            //     });
            // }
           
            $this->dispatch('showToast', 
            type: 'success', 
            message: $media->type == 'media' 
                ? __('upcertify::upcertify.background_deleted') 
                : ($media->type == 'pattern' 
                    ? __('upcertify::upcertify.pattern_deleted') 
                    : __('upcertify::upcertify.attachment_deleted'))
        );
        }
    }

    #[Layout('upcertify::layouts.app')]
    public function render() {
        $this->useAsShapeIcons();
        $this->useAsBadeIcons();
        $this->useAsFrames();
        $this->useAsAttachments();
        return view('upcertify::livewire.create-certificate.create-certificate');
    }

    public function uploadMedia() {
        $this->validate([
            'media'      => 'required|mimes:' . implode(',', $this->allowFileExt) . '|max:' . $this->fileSize, // Max size in KB
            'media_title' => 'required|string|max:255|min:3',
        ], [], ['media' => 'media']);

        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showToast', 
               type: 'error',
               message: __('general.demosite_res_txt')
            );
            $this->dispatch('closeModal');
            return;
        }

        if(!empty($this->media)) {
            $originalName = $this->media->getClientOriginalName();
            $slugifiedName = Str::slug($this->media_title) . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
            $counter = 1;
            $newSlugifiedName = $slugifiedName;
            while (Storage::disk(getStorageDisk())->exists('upcertify/' . $newSlugifiedName)) {
                $newSlugifiedName = Str::slug($this->media_title) . '-' . $counter . '.' . pathinfo($slugifiedName, PATHINFO_EXTENSION);
                $counter++;
            }
            $this->media->storeAs('upcertify/'.$this->media_type, $newSlugifiedName, getStorageDisk());
            $newMedia = Media::create([
                'title' => $this->media_title,
                'type' =>  Media::TYPE[$this->media_type],
                'path' => 'upcertify/' . $this->media_type . '/' . $newSlugifiedName,
            ]);
            if($newMedia) {
                $this->dispatch('closeModal');
                if($this->media_type == 'media') {
                    $this->backgrounds = $this->backgrounds->prepend($newMedia);
                }elseif($this->media_type == 'pattern') {
                    $this->patterns = $this->patterns->prepend($newMedia);
                }  
                // else {
                //     $this->attachments = $this->attachments->prepend($newMedia);
                // }
                $this->reset('media_title', 'media');
            }
        }
    }

    function saveCertificateCanvas($dirName, $name, $imageUrl) {
        $file_ext = ".png";
        $imageName = $name;
    
        // Get the storage disk dynamically
        $disk = getStorageDisk();
    
        // Check if the file already exists and generate a unique name if necessary
        $i = 0;
        while (Storage::disk($disk)->exists($dirName . '/' . $imageName . $file_ext)) {
            $i++;
            $imageName = preg_replace('/\(\d+\)$/', '', $name) . '(' . $i . ')';
        }
    
        $fileName = $imageName . $file_ext;
        $filePath = $dirName . '/' . $fileName;
    
        // Decode the base64 image
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageUrl));
        if ($image === false) {
            throw new \Exception("Failed to decode base64 image");
        }
    
        // Save the image file to the specified disk
        $storeFile = Storage::disk($disk)->put($filePath, $image);
        if ($storeFile === false) {
            throw new \Exception("Failed to save image file to disk: $filePath");
        }
    
        if ($storeFile) {
            return $filePath; // Return the full path to the saved file
        }
    
        return '';
    }

    public function publishCertificate() {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showToast', 
               type: 'error',
               message: __('general.demosite_res_txt')
            );
            return;
        }
        $slug = Str::slug($this->title);
        $this->thumbnail_url = $this->saveCertificateCanvas('upcertify/templates', $slug, $this->body['thumbnail']);
        $certificate = Template::where('id', $this->id)->where('user_id', Auth::id())->first();

        if (isset($this->body['thumbnail'])) {
            unset($this->body['thumbnail']);
        }

        if( empty($this->body['elementsInfo']) ) {
            $this->dispatch('showToast', type: 'error', message: __('upcertify::upcertify.elements_not_found'));
            return;
        }

        if( empty($this->title) ) {
            $this->dispatch('showToast', type: 'error', message: __('upcertify::upcertify.title_not_found'));
            $this->tab = 'general';
            return;
        }
        $whare = ['id' => empty($this->as_template) ? $this->id : null,  'user_id' => Auth::id()];
        $certificate = Template::updateOrCreate(
            $whare,
            [
                'title' => $this->title, 
                'user_id' => Auth::id(), 
                'thumbnail_url' => $this->thumbnail_url,
                'status' => 'publish',
                'body' => $this->body,
            ]
        );


        if($certificate) {
            $this->dispatch('showToast', type: 'success', message: __('upcertify::upcertify.certificate_published'));
            sleep(1);
            $url = route('upcertify.certificate-list');
            return redirect($url);
        }
    }

    public function getGoogleFonts() {
        $timeout = 30;
        try {
            $response = Http::timeout($timeout)->get('https://www.googleapis.com/webfonts/v1/webfonts?key=' . config('upcertify.google_font_api'));
            if ($response->successful()) {
                $fonts = $response->json()['items'];
                return $fonts;
            } else {
                Log::error('Failed to fetch Google Fonts: ' . $response->status());
                return [];
            }
        } catch (\Exception $e) {
            Log::error('Error fetching Google Fonts: ' . $e->getMessage());
            return [];
        }
    }
}