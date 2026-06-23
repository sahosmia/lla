<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultSettingSeeder;
use Illuminate\Database\Seeder;

class V110Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultSettingSeeder::class, ['version' => '1.10']);
    }
}
