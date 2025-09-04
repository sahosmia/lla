<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultPageSettingSeeder;
use Database\Seeders\DefaultSettingSeeder;
use Database\Seeders\EmailTemplateSeeder;
use Illuminate\Database\Seeder;

class V111Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultSettingSeeder::class, ['version' => '1.11']);
        $this->callWith(DefaultPageSettingSeeder::class, ['version' => '1.11']);
        $this->callWith(EmailTemplateSeeder::class, ['version' => '1.11']);
    }
}
