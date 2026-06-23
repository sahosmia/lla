<?php

namespace Modules\Quiz\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Livewire\Livewire;
use Modules\Quiz\Console\Commands\AssignQuiz;
use Modules\Quiz\Livewire\Pages\Student\QuizAttempt\QuizAttempt;
use Modules\Quiz\Livewire\Pages\Student\QuizDetails\QuizDetails;
use Modules\Quiz\Livewire\Pages\Student\QuizListing\QuizListing as QuizListingQuizListing;
use Modules\Quiz\Livewire\Pages\Student\QuizResult\QuizResult;
use Modules\Quiz\Livewire\Pages\Tutor\QuizListing\QuizListing;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\QuestionManager;
use Modules\Quiz\Livewire\Pages\Tutor\QuizMark\QuizMark;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\CreateQuestion;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\EditQuiz;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\QuizSettings;
use Modules\Quiz\Livewire\Pages\Tutor\QuizCreation\QuizAttempts;


class QuizServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Quiz';

    protected string $nameLower = 'quiz';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
        Livewire::component('quiz::quiz-settings',                          QuizSettings::class);
        Livewire::component('quiz::quiz-listing',                           QuizListing::class);
        Livewire::component('quiz::quiz-attempts',                          QuizAttempts::class);
        Livewire::component('quiz::quiz-details',                           QuizDetails::class);
        Livewire::component('quiz::quiz-attempt',                           QuizAttempt::class);
        Livewire::component('quiz::quiz-result',                            QuizResult::class);
        Livewire::component('quiz::student-quiz-listing',                   QuizListingQuizListing::class);
        Livewire::component('quiz::quiz-mark',                              QuizMark::class);
        Livewire::component('quiz::question-manager',                       QuestionManager::class);
        Livewire::component('quiz::create-question',                        CreateQuestion::class);
        Livewire::component('quiz::edit-quiz',                              EditQuiz::class);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        $this->commands([AssignQuiz::class]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'resources/lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'resources/lang'));
        }
    }

    /**
     * Register config.
     */
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

                    $this->publishes([$file->getPathname() => config_path($relativePath)], 'config');
                    $this->mergeConfigFrom($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        $componentNamespace = $this->module_namespace($this->name, $this->app_path(config('modules.paths.generator.component-class.path')));
        Blade::componentNamespace($componentNamespace, $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->nameLower)) {
                $paths[] = $path . '/modules/' . $this->nameLower;
            }
        }

        return $paths;
    }
}
