<?php

namespace Database\Seeders\VersionSeeders;

use App\Models\Addon;
use Database\Seeders\DefaultSettingSeeder;
use Illuminate\Database\Seeder;
use Nwidart\Modules\Facades\Module;

class V218Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callWith(DefaultSettingSeeder::class, ['version' => '2.1.8']);
        if (!empty(Module::all())) {
            $addons = getAddons();
            foreach (Module::all() as $module) {
                if ($module->get('version') == 'lite') {
                    continue;
                }
                Addon::updateOrCreate([
                    'name' => $addons[$module->getLowerName()]['name'] ?? $module->getName(),
                    'slug' => $module->getLowerName(),
                ], [
                    'description'   => $module->getDescription(),
                    'image'         => $addons[$module->getLowerName()]['image'] ?? null,
                    'status'        => $module->isEnabled() ? 'enabled' : 'disabled',
                    'meta_data'     => [
                        'latest_version'     => $module->get('version') ?? '1.0',
                        'commands_installed' => true
                    ],
                ]);
            }
        }
    }
}
