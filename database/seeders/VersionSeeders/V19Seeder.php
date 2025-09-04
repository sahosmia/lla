<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultPageSettingSeeder;
use Database\Seeders\DefaultSettingSeeder;
use Illuminate\Database\Seeder;

class V19Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultSettingSeeder::class, ['version' => '1.9']);
        $this->callWith(DefaultPageSettingSeeder::class, ['version' => '1.9']);
    }
}
