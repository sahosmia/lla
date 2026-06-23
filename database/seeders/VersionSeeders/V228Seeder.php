<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultSettingSeeder;
use Database\Seeders\UpdateRoleSeeder;
use Illuminate\Database\Seeder;

class V228Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultSettingSeeder::class, ['version' => '2.2.8']);
        $this->callWith(UpdateRoleSeeder::class);
    }
}

