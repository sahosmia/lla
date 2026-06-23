<?php

namespace Modules\TrainingCalendar\Database\Seeders;

use Illuminate\Database\Seeder;
use Larabuild\Optionbuilder\Facades\Settings;

class TrainingCalendarDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Settings::set('_training_calendar', 'allow_free_training', 'yes');
        Settings::set('_training_calendar', 'enforce_registration_deadline', 'yes');
        Settings::set('_training_calendar', 'enable_seat_limit', 'yes');
        Settings::set('_training_calendar', 'default_max_seats', 50);
        Settings::set('_training_calendar', 'require_login', 'yes');
    }
}
