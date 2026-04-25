<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class CourseBundlesModuleManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    protected $status = null;

    public function run($status = null): void
    {
        $this->status = $status;

        if($this->status == 'enabled'){
            $this->moduleEnabled();
        } elseif($this->status = 'disabled'){
            $this->moduleDisabled();
        } elseif($this->status = 'deleted'){
            $this->moduleDeleted();
        }
    }

    protected function moduleEnabled()
    {
        Log::info('module enabled seeder');

        $coursesMenu = MenuItem::whereHas('menu', fn($query) => $query->whereLocation('header'))->where('label', 'Courses')->first();
        $headerMenu = Menu::whereLocation('header')->select('id')->latest()->first();
        if (empty($coursesMenu) && !empty($headerMenu)) {
            $coursesMenu = MenuItem::create([
                'menu_id'   => $headerMenu->id,
                'label'     => 'Courses',
                'parent_id' => null,
                'route'     => url('search-courses'),
                'type'      => 'page',
                'sort'      => '3',
            ]);
        }
        if (!empty($coursesMenu) && !empty($headerMenu)) {
            MenuItem::firstOrCreate(
                [
                    'menu_id'   => $headerMenu->id,
                    'parent_id' => $coursesMenu->id,
                    'label'     => 'Search Courses',
                ],
                [
                    'route'     => url('search-courses'),
                    'type'      => 'page',
                    'sort'      => '1',
                    'class'     => '',
                ]
            );
            MenuItem::firstOrCreate(
                [
                    'menu_id'   => $headerMenu->id,
                    'parent_id' => $coursesMenu->id,
                    'label'     => 'Search Course Bundles',
                ],
                [
                    'route'     => url('course-bundles'),
                    'type'      => 'page',
                    'sort'      => '2',
                    'class'     => '',
                ]
            );
        }
        Artisan::call('cache:clear');
    }

    protected function moduleDisabled()
    {
        Log::info('module disabled seeder');
        $coursesMenu = MenuItem::whereHas('menu', fn($query) => $query->whereLocation('header'))->where('label', 'Courses')->first();
        $headerMenu = Menu::whereLocation('header')->select('id')->latest()->first();
        if (!empty($coursesMenu) && !empty($headerMenu)) {
            Log::info(MenuItem::where('menu_id', $headerMenu->id)
            ->where('parent_id', $coursesMenu->id)
            ->whereIn('label', ['Search Courses', 'Search Course Bundles'])->toRawSql());
            MenuItem::where('menu_id', $headerMenu->id)
            ->where('parent_id', $coursesMenu->id)
            ->whereIn('label', ['Search Courses', 'Search Course Bundles'])
            ->delete();
            Artisan::call('cache:clear');
        }
    }

    protected function moduleDeleted()
    {
        Log::info('module deleting seeder');
        
        $coursesMenu = MenuItem::whereHas('menu', fn($query) => $query->whereLocation('header'))->where('label', 'Courses')->first();
        $headerMenu = Menu::whereLocation('header')->select('id')->latest()->first();
        if (!empty($coursesMenu) && !empty($headerMenu)) {
            MenuItem::where('menu_id', $headerMenu->id)
            ->where('parent_id', $coursesMenu->id)
            ->whereIn('label', ['Search Courses', 'Search Course Bundles'])
            ->delete();
            Artisan::call('cache:clear');
        }
    }

}