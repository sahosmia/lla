<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\RolePermissionsSeeder;
use Database\Seeders\LanguageSeeder;
use Illuminate\Database\Seeder;

class V224Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(LanguageSeeder::class);
    }
}
