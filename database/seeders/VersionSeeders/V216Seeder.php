<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultSettingSeeder;
use Database\Seeders\NotificationTemplateSeeder;
use Illuminate\Database\Seeder;
class V216Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultSettingSeeder::class, ['version' => '2.1.6']);
        $this->callWith(NotificationTemplateSeeder::class, ['version' => '2.1.6']);
    }
}
