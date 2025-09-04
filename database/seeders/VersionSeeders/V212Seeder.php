<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\EmailTemplateSeeder;
use Illuminate\Database\Seeder;

class V212Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(EmailTemplateSeeder::class, ['version' => '2.1.1']);
    }
}
