<?php

namespace Database\Seeders\VersionSeeders;

use Illuminate\Database\Seeder;
use Database\Seeders\DefaultSettingSeeder;
use Database\Seeders\CurrencyConversionSeeder;

class V302Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultSettingSeeder::class, ['version' => '3.0.2']);
        $this->callWith(CurrencyConversionSeeder::class);
    }
}

