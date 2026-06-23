<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultSettingSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\DefaultPageSettingSeeder;
use App\Models\MenuItem;
class V215Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultPageSettingSeeder::class, ['version' => '2.1.5']);

        $this->callWith(DefaultSettingSeeder::class, ['version' => '2.1.5']);

        MenuItem::create([
            'menu_id' => 1,
            'parent_id' => 1,
            'label' => 'Home Page 09',
            'route' => url('home-nine'),
            'type' => 'custom',
            'sort' => '1',
            'class' => '',
        ]);
    }
}
