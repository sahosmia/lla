<?php

namespace App\Livewire\Pages\Admin\Upgrade;

use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Larabuild\Optionbuilder\Facades\Settings;
use Livewire\Component;

class Upgrade extends Component
{
    use WithFileUploads;
    public $postMaxSize;
    public $uploadMaxFilesize;
    public $isPostMaxSizeValid;
    public $isUploadMaxFilesizeValid;
    public $currentVersion;
    public $symlinkAllowed;
    public $validationErrors = [];
    public $requiredFiles = [
        'composer.json',
        'package.json',
        'vite.config.js',
        'tailwind.config.js',
        // '.env',
        'addons.json',
        'artisan',
        'app/',
        'bootstrap/',
        'config/',
        'database/',
        'lang/',
        'node_modules/',
        // 'packages/',
        'public/',
        'resources/',
        'routes/',
        // 'storage/',
        'vendor/',
    ];
    public $file;

    public function mount()
    {
        $this->postMaxSize = ini_get('post_max_size');
        $this->uploadMaxFilesize = ini_get('upload_max_filesize');
        $this->isPostMaxSizeValid = $this->parseSize($this->postMaxSize) >= 512 * 1024 * 1024 ;
        $this->isUploadMaxFilesizeValid = $this->parseSize($this->uploadMaxFilesize) >= 512 * 1024 * 1024;
       
        $this->symlinkAllowed = !in_array('symlink', explode(',', ini_get('disable_functions')));

        $this->currentVersion = setting('admin_settings.lernen_version');
        if(empty($this->currentVersion)){
            $this->currentVersion = json_decode(file_get_contents(base_path('composer.json')), true)['version'] ?? 'Unknown';
        }
    }
    #[Layout('layouts.admin-app')]
    public function render()
    {
        $this->currentVersion = $this->getCurrentVersion();
        return view('livewire.pages.admin.upgrade.upgrade');
    }

    public function upgradeLernen()
    {
       
        File::put(storage_path('logs/upgrade.log'), '');
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 3000);
        ini_set('post_max_size', '1024M');
        ini_set('upload_max_filesize', '1024M');
        $this->validationErrors = [];
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        Log::channel('upgrade')->info('Upgrade started...');
        $this->validate([
            'file' => 'required|file|mimes:zip',
        ]);
        Log::channel('upgrade')->info('Uploaded file is a valid zip file...');
        $lernenFileName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
        try{
            Artisan::call('down');
            $uploadedZip = Storage::disk('local')->putFileAs('lernen-updates', $this->file, $lernenFileName . '.zip');
            $getLatestUpdateFile = storage_path('app/' . $uploadedZip);
            $currentVersion = $this->getCurrentVersion();
            $zipArchive = new \ZipArchive();
            if($zipArchive->open($getLatestUpdateFile) === true) {
                foreach($this->requiredFiles as $file){ 
                    if ($zipArchive->locateName($file) === false) {
                        $this->validationErrors[] = __('admin/general.missing_file_or_folder', ['file' => $file]);
                    }
                }
                Log::channel('upgrade')->info('All required files and folders are present in the zip file...');
            }

            if (!empty($this->validationErrors)) {
                @unlink(storage_path('app/' . $uploadedZip));
                Log::channel('upgrade')->error('Validation errors found...');
                Artisan::call('up');
               return;
            }

            $composerJsonContent = $zipArchive->getFromName('composer.json');
            $composerData = json_decode($composerJsonContent, true);
            $newVersion = $composerData['version'] ?? '1.0';

            if(version_compare($currentVersion, $newVersion, '>=')){
                @unlink(storage_path('app/' . $uploadedZip));
                Log::channel('upgrade')->error('Your current version is already the latest version...');
                $this->dispatch('showAlertMessage', type: 'error', message: __('admin/general.already_latest'));
                Artisan::call('up');
                return;
            }

            if (!is_writable(base_path()) || !is_writable(base_path('vendor'))) {
                @unlink(storage_path('app/' . $uploadedZip));
                Log::channel('upgrade')->error('Base directory is not writable...');
                $this->dispatch('showAlertMessage', type: 'error', message: __('admin/general.base_dir_not_writable'));
                Artisan::call('up');
                return;
            }

            $zipArchive->extractTo(base_path());
            $zipArchive->close();
            @unlink(storage_path('app/' . $uploadedZip));
            $this->dispatch('showAlertMessage', type: 'success', message: __('admin/general.update_successful'));
            $this->runArtisanCommands($currentVersion, $newVersion);
            return $this->redirect(route('admin.upgrade'), true);
        }
        catch (\Exception $e) {
            Log::channel('upgrade')->error($e->getMessage());
            Artisan::call('up');
            $this->dispatch('showAlertMessage', type: 'error', message: __('admin/general.update_failed'));
        }
        $this->reset('file');
    }
    
    private function getCurrentVersion()
    {
        if(!empty(setting('admin_settings.version'))){
            return setting('admin_settings.version');
        }
        $composerJsonPath = base_path("composer.json");
        if (File::exists($composerJsonPath)) {
            $composerConfig = json_decode(File::get($composerJsonPath), true);
            return $composerConfig['version'] ?? '1.0';
        }
        return '1.0';
    }
    /**
     * Run artisan commands
     * @param string $fromVersion
     * @param string $toVersion
     */
    private function runArtisanCommands($fromVersion, $toVersion)
    {
        Artisan::call('up');
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('upgrade:database', ['--from_version' => $fromVersion, '--to_version' => $toVersion]);
        // Artisan::call('translations:import');
        Settings::set('admin_settings', 'version', $toVersion);
        Artisan::call('optimize:clear');  
    }

    private function parseSize($size)
    {
        $unit = strtolower(substr($size, -1));
        $value = (int) $size;
    
        switch ($unit) {
            case 'k': return $value * 1024;
            case 'm': return $value * 1024 * 1024;
            case 'g': return $value * 1024 * 1024 * 1024;
            case 't': return $value * 1024 * 1024 * 1024 * 1024;
            default: return $value;
        }
    }
}
