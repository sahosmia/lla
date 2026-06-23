<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $this->call([
            CountrySeeder::class,
            CountryStatesSeeder::class,
            LanguageSeeder::class,
            RolePermissionsSeeder::class,
            EmailTemplateSeeder::class,
            NotificationTemplateSeeder::class,
            DefaultSettingSeeder::class,
            GeneralSeeder::class,
            TutorSeeder::class,
            StudentSeeder::class,
            DefaultPageSettingSeeder::class,
            BlogCategoriesSeeder::class,
            BlogTagSeeder::class,
            BlogSeeder::class,
        ]);

        Artisan::call('module:enable Meetfusion');
        Artisan::call('module:enable LaraPayease');

        Schema::enableForeignKeyConstraints();
    }
}
