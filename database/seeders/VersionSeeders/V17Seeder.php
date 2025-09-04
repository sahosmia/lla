<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultPageSettingSeeder;
use Illuminate\Database\Seeder;

class V17Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultPageSettingSeeder::class, ['version' => '1.7']);
    }
}
