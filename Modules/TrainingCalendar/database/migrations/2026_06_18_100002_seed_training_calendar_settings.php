<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Larabuild\Optionbuilder\Facades\Settings;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        Permission::firstOrCreate(['name' => 'can-manage-training-calendar', 'guard_name' => 'web']);

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$adminRole->hasPermissionTo('can-manage-training-calendar')) {
            $adminRole->givePermissionTo('can-manage-training-calendar');
        }

        if (!Schema::hasTable(config('optionbuilder.db_prefix') . 'settings')) {
            return;
        }

        Settings::set('_training_calendar', 'allow_free_training', 'yes');
        Settings::set('_training_calendar', 'enforce_registration_deadline', 'yes');
        Settings::set('_training_calendar', 'enable_seat_limit', 'yes');
        Settings::set('_training_calendar', 'default_max_seats', '50');
        Settings::set('_training_calendar', 'require_login', 'yes');

        Cache::forget('optionbuilder__settings');
    }

    public function down(): void
    {
        //
    }
};
