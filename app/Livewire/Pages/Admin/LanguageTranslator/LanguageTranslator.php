<?php

namespace App\Livewire\Pages\Admin\LanguageTranslator;
use Illuminate\Support\Facades\Cache;
use App\Services\TranslationService;
use Illuminate\Support\Facades\File;
use App\Jobs\TranslateLangFilesJob;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LanguageTranslator extends Component
{
    public $translationMethod   = true;
    public $selectedLanguages   = [];
    public $translateFiles      = [];
    public $selectedFiles       = [];
    public $translations;
    public $targetLang;
    public $showFiles           = false;
    public $progress            = 0;
    public $running             = false;
    public $jobId;
    public $done                = false;
    
    private ?TranslationService  $translationService  = null;

    public function boot()
    {
        $this->translationService = new TranslationService();
    }

    public function mount()
    {
        if($this->translationMethod){
            $this->jobId = request('job_id');
            if ($this->jobId) {
                $this->progress     = Cache::get("translate_progress_{$this->jobId}", 0);
                $this->done         = Cache::get("translate_done_{$this->jobId}", false);
                $this->running      = !$this->done;
            }  
        } 

        $selectedCodes              = setting('_general.multi_language_list') ?? [];
        $this->selectedLanguages    = DB::table('languages')->whereIn('code', $selectedCodes)->pluck('name', 'code')->toArray();
        
        $this->translations         = $this->translationService->getAllTranslations();
        $this->dispatch('initSelect2', target: '.am-select2');
    }
    
    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.language-translator.language-translator');
    }

    public function translateLangFiles()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if (empty($this->targetLang)) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error'), message: __('general.please_select_language'));
            return;
        }

        $this->generateTranslateFiles();
        if($this->translationMethod)    {
            $this->progress     = 0;
            $this->done         = false;
            $this->running      = true;
            $this->jobId        = (string) Str::uuid();
            Cache::forget("translate_progress_{$this->jobId}");
            Cache::forget("translate_done_{$this->jobId}");
            dispatch(new TranslateLangFilesJob($this->translateFiles, $this->targetLang, $this->jobId));
            $this->dispatch('jobStarted', $this->jobId);
        } else {
            foreach($this->translateFiles as $index => $file) {
                $result  =$this->translationService->translateFileHandler($file, $this->targetLang);
                if($result) {
                    $this->dispatch('showAlertMessage', type: 'error', title: __('general.error'), message: $result);
                    return;
                }
            }
        } 
   
    }
    
    public function generateTranslateFiles()
    {
        $this->translateFiles = [];
        foreach ($this->translations as $path => $files) {
            foreach ($files as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $subFile) {
                        $this->translateFiles[] = "{$path}/{$key}/{$subFile}";
                    }
                } else {
                    $this->translateFiles[] = "{$path}/{$value}";
                }
            }
        }
    }

    public function pollProgress()
    {
        if (! $this->running || !$this->jobId) return;

        $this->progress     = Cache::get("translate_progress_{$this->jobId}", 0);
        $this->done         = Cache::get("translate_done_{$this->jobId}", false);

        if ($this->done) {
            session()->forget("job_id");
            $this->running = false;
            $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('general.translated_successfully'));
        }
    }
}
