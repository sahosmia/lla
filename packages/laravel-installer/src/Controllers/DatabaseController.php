<?php

namespace Froiden\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Froiden\LaravelInstaller\Helpers\DatabaseManager;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatabaseController extends Controller
{
    public $seederGroups = [
        'migrate' => [],
        'general' => [
            \Database\Seeders\RolePermissionsSeeder::class,
            \Database\Seeders\CountrySeeder::class,
            \Database\Seeders\CountryStatesSeeder::class,
            \Database\Seeders\GeneralSeeder::class,
            \Database\Seeders\LanguageSeeder::class,
            \Database\Seeders\BlogCategoriesSeeder::class,
            \Database\Seeders\BlogTagSeeder::class,
            \Database\Seeders\BlogSeeder::class,
        ],
        'pages' => [
            \Database\Seeders\DefaultSettingSeeder::class,
            \Database\Seeders\DefaultPageSettingSeeder::class,
            \Database\Seeders\EmailTemplateSeeder::class,
            \Database\Seeders\NotificationTemplateSeeder::class,
        ],
        'students' => [
            \Database\Seeders\StudentSeeder::class,
        ],
        'tutors' => [
            \Database\Seeders\TutorSeeder::class,
        ],
    ];
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        $seederGroups = $this->seederGroups;
        foreach ($seederGroups as $seeder => $classes) {
            $this->logSeederStatus($seeder, 'pending');
        }
        $seederStatus = '';
        $allDone = false;
        $nextSeeder = 'migrate';
        return view('vendor.installer.seeders', compact('seederGroups', 'seederStatus', 'allDone', 'nextSeeder'));
    }

    /**
     * Import or Seed Database data
     * 
     * @return \Illuminate\View\View
     */

    public function seed($type = 'migrate')
    {
        $seederGroups = $this->seederGroups;
        $seederClasses = $seederGroups[$type];
        $seederStatus = [];
        if (Storage::disk('local')->exists('seeder_logs.json')) {
            $seederStatus = json_decode(Storage::disk('local')->get('seeder_logs.json'), true);
        }
        if (empty($seederStatus[$type]['status']) || $seederStatus[$type]['status'] == 'pending') {
            $this->logSeederStatus($type, 'started');
            if (empty($seederClasses)) {
                $response = $this->databaseManager->migrateOnly();
            } else {
                foreach ($seederClasses as $seeder => $seederClass) {
                    try {
                        $response = $this->databaseManager->seed($seederClass);
                    } catch (\Exception $e) {
                        $this->logSeederStatus($type, 'failed', $e->getMessage());
                    }
                }
            }
            $seederStatus[$type]['status'] = 'completed';
            $this->logSeederStatus($type, 'completed');
        }

        $allDone = false;
        foreach ($seederGroups as $seeder => $classes) {
            if (!empty($seederStatus[$seeder]['status']) && $seederStatus[$seeder]['status'] == 'completed') {
                $seederStatus[$seeder]['status'] = 'completed';
                $allDone = true;
            } else {
                $seederStatus[$seeder] = [
                    'status' => 'pending',
                    'message' => ''
                ];
                $allDone = false;
                break;
            }
        }

        $nextSeeder = $this->getNextSeeder($seederGroups, $type);
        if (empty($nextSeeder)) {

            Artisan::call('module:enable Meetfusion');
            Artisan::call('module:enable LaraPayease');

            session()->put('message', ['message' => trans('installer_messages.final.finished')]);
        }
        return view('vendor.installer.seeders', compact('seederGroups', 'seederStatus', 'allDone', 'nextSeeder'));
    }

    private function logSeederStatus($seeder, $status, $message = '')
    {
        $logs = json_decode(Storage::disk('local')->get('seeder_logs.json'), true) ?? [];

        $logs[$seeder] = [
            'status' => $status,
            'message' => $message,
        ];
        // Save log to a file
        Storage::disk('local')->put('seeder_logs.json', json_encode($logs));
    }

    private function getNextSeeder($seeders, $currentKey)
    {
        $keys = array_keys($seeders); // Get all keys of the array
        $currentIndex = array_search($currentKey, $keys); // Find the index of the current key

        if ($currentIndex !== false && isset($keys[$currentIndex + 1])) {
            return $keys[$currentIndex + 1]; // Return the next key if it exists
        }
        return null; // No next key found
    }
}
