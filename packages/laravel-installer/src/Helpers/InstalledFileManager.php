<?php

namespace Froiden\LaravelInstaller\Helpers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Larabuild\Optionbuilder\Facades\Settings;

class InstalledFileManager
{
    /**
     * Create installed file.
     *
     * @return int
     */
    public function create()
    {
        file_put_contents(storage_path('installed'), '');
        Settings::set('admin_settings', 'is_installed', '1');
        Settings::set('admin_settings', 'version', $this->getCurrentVersion());
        Artisan::call('storage:link');
        Artisan::call('optimize:clear');
        Storage::disk('local')->delete('seeder_logs.json');
    }

    /**
     * Update installed file.
     *
     * @return int
     */
    public function update()
    {
        return $this->create();
    }

    protected function getCurrentVersion(){
        $composerJsonPath = base_path("composer.json");
        if (File::exists($composerJsonPath)) {
            $composerConfig = json_decode(File::get($composerJsonPath), true);
            return $composerConfig['version'] ?? '1.0';
        }
        return '1.0';
    }
}