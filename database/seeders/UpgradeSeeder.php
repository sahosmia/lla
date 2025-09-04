<?php

namespace Database\Seeders;

use Database\Seeders\VersionSeeders\V110Seeder;
use Database\Seeders\VersionSeeders\V111Seeder;
use Database\Seeders\VersionSeeders\V11Seeder;
use Database\Seeders\VersionSeeders\V12Seeder;
use Database\Seeders\VersionSeeders\V13Seeder;
use Database\Seeders\VersionSeeders\V14Seeder;
use Database\Seeders\VersionSeeders\V15Seeder;
use Database\Seeders\VersionSeeders\V16Seeder;
use Database\Seeders\VersionSeeders\V17Seeder;
use Database\Seeders\VersionSeeders\V18Seeder;
use Database\Seeders\VersionSeeders\V19Seeder;
use Database\Seeders\VersionSeeders\V201Seeder;
use Database\Seeders\VersionSeeders\V202Seeder;
use Database\Seeders\VersionSeeders\V203Seeder;
use Database\Seeders\VersionSeeders\V20Seeder;
use Database\Seeders\VersionSeeders\V210Seeder;
use Database\Seeders\VersionSeeders\V211Seeder;
use Database\Seeders\VersionSeeders\V212Seeder;
use Database\Seeders\VersionSeeders\V213Seeder;
use Database\Seeders\VersionSeeders\V214Seeder;
use Database\Seeders\VersionSeeders\V215Seeder;
use Database\Seeders\VersionSeeders\V216Seeder;
use Database\Seeders\VersionSeeders\V217Seeder;
use Database\Seeders\VersionSeeders\V218Seeder;
use Database\Seeders\VersionSeeders\V219Seeder;
use Database\Seeders\VersionSeeders\V220Seeder;
use Database\Seeders\VersionSeeders\V221Seeder;
use Database\Seeders\VersionSeeders\V222Seeder;
use Database\Seeders\VersionSeeders\V223Seeder;
use Database\Seeders\VersionSeeders\V224Seeder;
use Database\Seeders\VersionSeeders\V225Seeder;
use Database\Seeders\VersionSeeders\V226Seeder;
use Database\Seeders\VersionSeeders\V227Seeder;
use Database\Seeders\VersionSeeders\V228Seeder;
use Database\Seeders\VersionSeeders\V229Seeder;
use Database\Seeders\VersionSeeders\V30Seeder;
use Database\Seeders\VersionSeeders\V301Seeder;
use Database\Seeders\VersionSeeders\V302Seeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class UpgradeSeeder extends Seeder
{
    /**
     * Run the upgrade seeder.
     *
     * @param string $from_verison
     * @param string $to_version
     * @return void
     */
    public function run($from_version, $to_version)
    {
        $this->replaceDemoContentImages();
        $seeders = [

            '1.1'   => V11Seeder::class,
            '1.2'   => V12Seeder::class,
            '1.3'   => V13Seeder::class,
            '1.4'   => V14Seeder::class,
            '1.5'   => V15Seeder::class,
            '1.6'   => V16Seeder::class,
            '1.7'   => V17Seeder::class,
            '1.8'   => V18Seeder::class,
            '1.9'   => V19Seeder::class,
            '1.10'  => V110Seeder::class,
            '1.11'  => V111Seeder::class,
            '2.0'   => V20Seeder::class,
            '2.0.1' => V201Seeder::class,
            '2.0.2' => V202Seeder::class,
            '2.0.3' => V203Seeder::class,
            '2.1.0' => V210Seeder::class,
            '2.1.1' => V211Seeder::class,
            '2.1.2' => V212Seeder::class,
            '2.1.3' => V213Seeder::class,
            '2.1.4' => V214Seeder::class,
            '2.1.5' => V215Seeder::class,
            '2.1.6' => V216Seeder::class,
            '2.1.7' => V217Seeder::class,
            '2.1.8' => V218Seeder::class,
            '2.1.9' => V219Seeder::class,
            '2.2.0' => V220Seeder::class,
            '2.2.1' => V221Seeder::class,
            '2.2.2' => V222Seeder::class,
            '2.2.3' => V223Seeder::class,
            '2.2.4' => V224Seeder::class,
            '2.2.5' => V225Seeder::class,
            '2.2.6' => V226Seeder::class,
            '2.2.7' => V227Seeder::class,
            '2.2.8' => V228Seeder::class,
            '2.2.9' => V229Seeder::class,
            '3.0'   => V30Seeder::class,
            '3.0.1' => V301Seeder::class,
            '3.0.2' => V302Seeder::class,
        ];

        $seedersToRun = [];

        foreach ($seeders as $version => $seederClass) {
            if (version_compare($version, $from_version, '>') && version_compare($version, $to_version, '<=')) {
                $seedersToRun[] = $seederClass;
            }
        }

        foreach ($seedersToRun as $seederClass) {
            $this->call($seederClass);
        }

        Artisan::call('storage:unlink');
        Artisan::call('storage:link');

        if (!empty(Module::allEnabled())) {
            foreach (Module::allEnabled() as $enabledModule) {
                Artisan::call('module:publish', ['module' => $enabledModule->getName()]);
            }
        }
    }

    protected function replaceDemoContentImages() 
    {
        $shippedDemoContent = base_path('demo-content');
        $existingDemoContent = public_path('demo-content');

        if (File::exists($shippedDemoContent)) {
            $shippedFiles = File::allFiles($shippedDemoContent);

            foreach ($shippedFiles as $shippedFile) {
                $relativePath = $shippedFile->getRelativePathname();
                $destinationPath = $existingDemoContent . DIRECTORY_SEPARATOR . $relativePath;

                File::ensureDirectoryExists(dirname($destinationPath));
                if (!File::exists($destinationPath)) {
                    File::copy($shippedFile->getPathname(), $destinationPath);
                }
            }

            File::deleteDirectory($shippedDemoContent);
        }
    }
}
