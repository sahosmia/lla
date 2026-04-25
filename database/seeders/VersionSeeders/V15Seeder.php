<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\BlogCategoriesSeeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\BlogTagSeeder;
use Database\Seeders\DefaultPageSettingSeeder;
use Database\Seeders\DefaultSettingSeeder;
use Illuminate\Database\Seeder;

class V15Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(BlogCategoriesSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(BlogTagSeeder::class);

        $this->callWith(DefaultPageSettingSeeder::class, ['version' => '1.5']);
        $this->callWith(DefaultSettingSeeder::class, ['version' => '1.5']);
    }
}
