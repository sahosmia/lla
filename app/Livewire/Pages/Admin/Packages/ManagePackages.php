<?php

namespace App\Livewire\Pages\Admin\Packages;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Nwidart\Modules\Facades\Module;

class ManagePackages extends Component
{
    use WithFileUploads;
    public $postMaxSize;
    public $uploadMaxFilesize;
    public $isPostMaxSizeValid;
    public $isUploadMaxFilesizeValid;
    public $file;

    public function mount()
    {
        $this->postMaxSize = ini_get('post_max_size');
        $this->uploadMaxFilesize = ini_get('upload_max_filesize');
        $this->isPostMaxSizeValid = $this->parseSize($this->postMaxSize) >= 512 * 1024 * 1024 ;
        $this->isUploadMaxFilesizeValid = $this->parseSize($this->uploadMaxFilesize) >= 512 * 1024 * 1024;
    }
    
    #[Layout('layouts.admin-app')]
    public function render()
    {
        $packages = getAddons();
        foreach($packages as $package => $detail){
            $module = Module::find($package);
            $packages[$package]['status']     = $detail['type'] == 'core' ? 'active' : ($module?->isEnabled() ? 'active' : 'inactive');
            $packages[$package]['version']    = $module?->get('version') ?? 'lite';
        }
        return view('livewire.pages.admin.packages.manage-packages', compact('packages'));
    }

    public function addNewPackage()
    {
        $this->dispatch('toggleModel', id: 'addNewPackageModal', action: 'show');
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
