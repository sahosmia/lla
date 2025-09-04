<?php

namespace App\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\UpgradeSeeder;
use Illuminate\Console\Command;
use Larabuild\Optionbuilder\Facades\Settings;

class UpgradeDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade:database {--from_version=} {--to_version=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command upgrades the database from one version to another';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fromVersion = $this->option('from_version');
        $toVersion = $this->option('to_version');

        if (empty($fromVersion) || empty($toVersion) || !$this->parseVersion($fromVersion) || !$this->parseVersion($toVersion) || $fromVersion == $toVersion) {
            $this->error('Wrong versions provided');
            return;
        }

        (new DatabaseSeeder())->callWith(class: UpgradeSeeder::class, parameters: [
            'from_version' => $fromVersion,
            'to_version' => $toVersion
        ]);

        Settings::set('admin_settings', 'version', $toVersion);
        
        $this->info('Database upgraded from ' . $fromVersion . ' to ' . $toVersion);
    }

    /**
     * Parse and validate the version format.
     *
     * @param string $version
     * @return string
     */
    private function parseVersion(string $version): string
    {
        if (preg_match('/^\d{1,2}(\.\d{1,2}){1,2}?$/', $version)) {
            // Then convert to a float and check the range
            $number = (float) $version;
            return $number >= 1.0 && $number <= 99.99;
        }
        return false;
    }
}
