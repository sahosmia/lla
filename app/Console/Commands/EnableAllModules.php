<?php

namespace App\Console\Commands;

use App\Models\Addon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nwidart\Modules\Facades\Module;

class EnableAllModules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:enable-all {module?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable and seed all modules. This command is for development use only and should never be used in prouduction.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $addons = getAddons();

        $moduleName = $this->argument('module');

        foreach (Module::all() as $module) {
            if ($module->get('version') == 'lite') {
                continue;
            }

            if ($moduleName && $module->getLowerName() !== strtolower($moduleName)) {
                continue;
            }

            try {

                DB::transaction(function () use ($module, $addons) {
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
                });

                $module->enable();
                $this->info("Enabled: {$module->getName()}");

                Artisan::call("module:seeder {$module->getName()}");
                $this->info("Seeded: {$module->getName()}");
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th->getTraceAsString());
                $this->error("Error enabling module: {$module->getName()}.Reason: {$th->getMessage()}");
            }
        }
    }
}
