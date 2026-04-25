<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultSettingSeeder;
use Database\Seeders\RolePermissionsSeeder;
use Illuminate\Database\Seeder;

class V225Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultSettingSeeder::class, ['version' => '2.2.5']);
    }
}
