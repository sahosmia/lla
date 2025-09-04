<?php

namespace Modules\Courses\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Livewire\Livewire;
use Modules\Courses\Livewire\Components\DiscussionForum\DiscussionForum;
use Modules\Courses\Livewire\Pages\Admin\CommissionSettings as AdminCommissionSettings;
use Modules\Courses\Livewire\Pages\Admin\CourseEnrollments;
use Modules\Courses\Livewire\Pages\Admin\CourseListing as AdminCourseListing;
use Modules\Courses\Livewire\Pages\Course\CourseDetails;
use Modules\Courses\Livewire\Pages\Search\SearchCourses;
use Modules\Courses\Livewire\Pages\Student\CourseList\CourseList;
use Modules\Courses\Livewire\Pages\Student\CourseTaking\CourseTaking;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CourseBasicDetails;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CourseDiscussionForum;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CourseFaqs;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CourseMedia;
use Modules\Courses\Livewire\Pages\Admin\Categories;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CourseNoticeboard;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CoursePricing;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CoursePromotions;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CoursePublish;

use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\CourseSidebar;

use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\ManageCourseContent\Components\Curriculum;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components\ManageCourseContent\CourseContent;
use Modules\Courses\Livewire\Pages\Tutor\CourseListing\CourseListing;

class CoursesServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Courses';

    protected string $nameLower = 'courses';

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

        Livewire::component('courses::course-sidebar',                               CourseSidebar::class);
        Livewire::component('courses::course-details',                               CourseBasicDetails::class);
        Livewire::component('courses::course-media',                                 CourseMedia::class);
        Livewire::component('courses::course-content',                               CourseContent::class);
        Livewire::component('courses::course-pricing',                               CoursePricing::class);
        Livewire::component('courses::course-faqs',                                  CourseFaqs::class);
        Livewire::component('courses::course-promotions',                            CoursePromotions::class);
        Livewire::component('courses::course-discussion-forum',                      CourseDiscussionForum::class);
        Livewire::component('courses::course-noticeboard',                           CourseNoticeboard::class);
        Livewire::component('courses::course-publish',                               CoursePublish::class);
        Livewire::component('courses::manage-course-content.components.curriculum',  Curriculum::class);
        Livewire::component('courses::course-listing',                               CourseListing::class);
        Livewire::component('courses::search-courses',                               SearchCourses::class);
        Livewire::component('courses::course-detail',                                CourseDetails::class);
        Livewire::component('courses::admin.course-listing',                         AdminCourseListing::class);
        Livewire::component('courses::admin.course-enrollments',                     CourseEnrollments::class);
        Livewire::component('courses::admin.commission-settings',                    AdminCommissionSettings::class);
        Livewire::component('courses::student.course-taking',                        CourseTaking::class);
        Livewire::component('courses::discussion-forum',                              DiscussionForum::class);
        Livewire::component('courses::student.course-list',                           CourseList::class);
        Livewire::component('courses::admin.categories',                              Categories::class);

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
        // $this->commands([]);
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
        $langPath = resource_path('lang/modules/'.$this->nameLower);
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
        $viewPath = resource_path('views/modules/'.$this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower.'-module-views']);

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
            if (is_dir($path.'/modules/'.$this->nameLower)) {
                $paths[] = $path.'/modules/'.$this->nameLower;
            }
        }

        return $paths;
    }
}
