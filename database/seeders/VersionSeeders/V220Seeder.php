<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\RolePermissionsSeeder;
use Illuminate\Database\Seeder;

class V220Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(RolePermissionsSeeder::class);
    }
}
