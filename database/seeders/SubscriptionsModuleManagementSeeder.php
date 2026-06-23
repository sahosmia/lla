<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Larabuild\Pagebuilder\Models\Page;

class SubscriptionsModuleManagementSeeder extends Seeder
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
        $studentSubscrpitionPage = Page::whereName('Student Subscriptions')->first();
        if (!empty($studentSubscrpitionPage)) {
            $studentSubscrpitionPage->update([
                'status' => 'published'
            ]);
        }

        $tutorSubscrpitionPage = Page::whereName('Tutor Subscriptions')->first();
        if (!empty($tutorSubscrpitionPage)) {
            $tutorSubscrpitionPage->update([
                'status' => 'published'
            ]);
        }

        $subscriptionMenu = MenuItem::whereHas('menu', fn($query) => $query->whereLocation('header'))->where('label', 'Subscriptions')->first();
        $headerMenu = Menu::whereLocation('header')->select('id')->latest()->first();
        if (empty($subscriptionMenu) && !empty($headerMenu)) {
            $subscriptionMenu = MenuItem::create([
                'menu_id'   => $headerMenu->id,
                'label'     => 'Subscriptions',
                'parent_id' => null,
                'route'     => '#',
                'type'      => 'page',
                'sort'      => '5',
            ]);
        }
        if (!empty($subscriptionMenu) && !empty($headerMenu)) {
            MenuItem::firstOrCreate(
                [
                    'menu_id'   => $headerMenu->id,
                    'parent_id' => $subscriptionMenu->id,
                    'label'     => 'Student Subscriptions',
                ],
                [
                    'route'     => url('student-subscriptions'),
                    'type'      => 'page',
                    'sort'      => '3',
                    'class'     => '',
                ]
            );
            MenuItem::firstOrCreate(
                [
                    'menu_id'   => $headerMenu->id,
                    'parent_id' => $subscriptionMenu->id,
                    'label'     => 'Tutor Subscriptions',
                ],
                [
                    'route'     => url('tutor-subscriptions'),
                    'type'      => 'page',
                    'sort'      => '4',
                    'class'     => '',
                ]
            );
        }
        Artisan::call('cache:clear');
    }

    protected function moduleDisabled()
    {
        Log::info('module disabled seeder');
        $studentSubscrpitionPage = Page::whereName('Student Subscriptions')->first();
        if (!empty($studentSubscrpitionPage)) {
            $studentSubscrpitionPage->update([
                'status' => 'draft'
            ]);
        }

        $tutorSubscrpitionPage = Page::whereName('Tutor Subscriptions')->first();
        if (!empty($tutorSubscrpitionPage)) {
            $tutorSubscrpitionPage->update([
                'status' => 'draft'
            ]);
        }

        $subscriptionMenu = MenuItem::whereHas('menu', fn($query) => $query->whereLocation('header'))->where('label', 'Subscriptions')->first();
        $headerMenu = Menu::whereLocation('header')->select('id')->latest()->first();
        if (!empty($subscriptionMenu) && !empty($headerMenu)) {
            MenuItem::where('menu_id', $headerMenu->menu_id)
            ->where('parent_id', $subscriptionMenu->id)
            ->whereIn('label', ['Student Subscriptions', 'Tutor Subscriptions'])
            ->delete();
            $subscriptionMenu->delete();
            Artisan::call('cache:clear');
        }
    }

    protected function moduleDeleted()
    {
        Log::info('module deleting seeder');
        
        $studentSubscrpitionPage = Page::whereSlug('student-subscriptions')->first();
        if (!empty($studentSubscrpitionPage)) {
            $studentSubscrpitionPage->delete();
        }
        

        $tutorSubscrpitionPage = Page::whereSlug('tutor-subscriptions')->first();
        if (!empty($tutorSubscrpitionPage)) {
            $tutorSubscrpitionPage->delete();
        }

        $moreMenu = MenuItem::whereHas('menu', fn($query) => $query->whereLocation('header'))->where('label', 'More')->first();
        if (!empty($moreMenu)) {
            MenuItem::where('menu_id', $moreMenu->menu_id)
            ->where('parent_id', $moreMenu->id)
            ->whereIn('label', ['Student Subscriptions', 'Tutor Subscriptions'])
            ->delete();
            Artisan::call('cache:clear');
        }
    }

}