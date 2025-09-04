<?php

namespace App\Listeners;

use App\Models\Addon;
use Database\Seeders\SubscriptionsModuleManagementSeeder;
use Database\Seeders\CourseBundlesModuleManagementSeeder;
use Illuminate\Support\Facades\Log;

class ModuleManagementListener
{
    /**
     * Handle the event.
     */
    public function handle($event, $data): void
    {
        $module = $data[0] ?? null;
        if (empty($module)) {
            return;
        }

        $addon = Addon::whereSlug($module->getLowerName())->first();
        if ($addon) {
            if ($event == 'modules.'.$module->getLowerName().'.deleted') {
               $addon->delete();
            } else {
                $addon->update(['status' => $module->isEnabled() ? 'enabled' : 'disabled']);
            }
        }

        //Subscrpitions module enabled   
        if ($event == 'modules.subscriptions.enabled' && $module->getName() === 'Subscriptions') {
            Log::info('module enabled');
            $seeder = new SubscriptionsModuleManagementSeeder();
            $seeder->run('enabled');
        } 

        //Subscrpitions module disabled
        elseif ($event == 'modules.subscriptions.disabled' && $module->getName() === 'Subscriptions') {
            Log::info('module disabled');
            $seeder = new SubscriptionsModuleManagementSeeder();
            $seeder->run('disabled');
        }

        //Subscrpitions module deleted
        elseif ($event == 'modules.subscriptions.deleted' && $module->getName() === 'Subscriptions') {
            Log::info('module deleted');
            $seeder = new SubscriptionsModuleManagementSeeder();
            $seeder->run('deleted');
        }

        //CourseBundles module enabled
        if ($event == 'modules.coursebundles.enabled' && $module->getName() === 'CourseBundles') {
            $seeder = new CourseBundlesModuleManagementSeeder();
            $seeder->run('enabled');
        } 

        //CourseBundles module disabled
        elseif ($event == 'modules.coursebundles.disabled' && $module->getName() === 'CourseBundles') {
            $seeder = new CourseBundlesModuleManagementSeeder();
            $seeder->run('disabled');
        }

        //CourseBundles module deleted
        elseif ($event == 'modules.coursebundles.deleted' && $module->getName() === 'CourseBundles') {
            $seeder = new CourseBundlesModuleManagementSeeder();
            $seeder->run('deleted');
        }

    }
}
