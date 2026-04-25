<?php

namespace App\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DefaultSettingSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SpecificDefaultSettingSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:settings {--edition=} {--section=} {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding Version or Keys based Default Settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $version = $this->option('edition');
        $section = $this->option('section');
        $key = $this->option('key');

        (new DatabaseSeeder())->callWith(class: DefaultSettingSeeder::class, parameters: [
            'version' => $version,
            'section' => $section,
            'key'     => $key
        ]);
    }
}
