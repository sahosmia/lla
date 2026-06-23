<?php

namespace Modules\TrainingCalendar\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\TrainingCalendar\Livewire\Pages\Admin\ModuleSettings;
use Modules\TrainingCalendar\Livewire\Pages\Admin\RegistrationListing as AdminRegistrationListing;
use Modules\TrainingCalendar\Livewire\Pages\Admin\TrainingListing as AdminTrainingListing;
use Modules\TrainingCalendar\Livewire\Pages\Student\MyTrainings;
use Modules\TrainingCalendar\Livewire\Pages\Student\TrainingDetail as StudentTrainingDetail;
use Modules\TrainingCalendar\Livewire\Pages\Tutor\CreateTraining;
use Modules\TrainingCalendar\Livewire\Pages\Tutor\RegistrationListing;
use Modules\TrainingCalendar\Livewire\Pages\Tutor\SendNotice;
use Modules\TrainingCalendar\Livewire\Pages\Tutor\TrainingListing;
use Modules\TrainingCalendar\Livewire\Pages\Public\BrowseTrainings;
use Modules\TrainingCalendar\Livewire\Pages\Public\TrainingDetail;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class TrainingCalendarServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'TrainingCalendar';

    protected string $nameLower = 'trainingcalendar';

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));

        Livewire::component('trainingcalendar::browse-trainings', BrowseTrainings::class);
        Livewire::component('trainingcalendar::training-detail', TrainingDetail::class);
        Livewire::component('trainingcalendar::tutor.training-listing', TrainingListing::class);
        Livewire::component('trainingcalendar::tutor.create-training', CreateTraining::class);
        Livewire::component('trainingcalendar::tutor.registration-listing', RegistrationListing::class);
        Livewire::component('trainingcalendar::tutor.send-notice', SendNotice::class);
        Livewire::component('trainingcalendar::student.my-trainings', MyTrainings::class);
        Livewire::component('trainingcalendar::student.training-detail', StudentTrainingDetail::class);
        Livewire::component('trainingcalendar::admin.training-listing', AdminTrainingListing::class);
        Livewire::component('trainingcalendar::admin.registration-listing', AdminRegistrationListing::class);
        Livewire::component('trainingcalendar::admin.module-settings', ModuleSettings::class);
    }

    public function register(): void
    {
        //
    }

    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'resources/lang'), $this->nameLower);
        }
    }

    protected function registerConfig(): void
    {
        $relativeConfigPath = config('modules.paths.generator.config.path');
        $configPath = module_path($this->name, $relativeConfigPath);

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $relativePath = str_replace($configPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $configKey = $this->nameLower . '.' . str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $relativePath);
                    $key = ($relativePath === 'config.php') ? $this->nameLower : $configKey;

                    $this->mergeConfigFrom($file->getPathname(), $key);
                }
            }
        }
    }

    public function registerViews(): void
    {
        $sourcePath = module_path($this->name, 'resources/views');
        $this->loadViewsFrom($sourcePath, $this->nameLower);
    }
}
