<?php

use Illuminate\Support\Facades\Route;
use Modules\TrainingCalendar\Livewire\Pages\Admin\ModuleSettings;
use Modules\TrainingCalendar\Livewire\Pages\Admin\RegistrationListing as AdminRegistrationListing;
use Modules\TrainingCalendar\Livewire\Pages\Admin\TrainingListing as AdminTrainingListing;
use Modules\TrainingCalendar\Livewire\Pages\Public\BrowseTrainings;
use Modules\TrainingCalendar\Livewire\Pages\Public\TrainingDetail;
use Modules\TrainingCalendar\Livewire\Pages\Student\MyTrainings;
use Modules\TrainingCalendar\Livewire\Pages\Student\TrainingDetail as StudentTrainingDetail;
use Modules\TrainingCalendar\Livewire\Pages\Tutor\CreateTraining;
use Modules\TrainingCalendar\Livewire\Pages\Tutor\RegistrationListing;
use Modules\TrainingCalendar\Livewire\Pages\Tutor\SendNotice;
use Modules\TrainingCalendar\Livewire\Pages\Tutor\TrainingListing;

Route::middleware(['locale', 'maintenance', 'enabled:TrainingCalendar'])
    ->as('trainingcalendar.')
    ->prefix('training-calendar')
    ->group(function () {
        Route::get('/', BrowseTrainings::class)->name('browse');

        Route::middleware(['auth', 'verified', 'onlineUser', 'role:tutor'])->name('tutor.')->prefix('tutor')->group(function () {
            Route::get('/trainings', TrainingListing::class)->name('trainings');
            Route::get('/create', CreateTraining::class)->name('create');
            Route::get('/edit/{trainingId}', CreateTraining::class)->name('edit');
            Route::get('/{trainingId}/registrations', RegistrationListing::class)->name('registrations');
            Route::get('/{trainingId}/send-notice', SendNotice::class)->name('send-notice');
        });

        Route::middleware(['auth', 'verified', 'onlineUser', 'role:student'])->name('student.')->prefix('student')->group(function () {
            Route::get('/my-trainings', MyTrainings::class)->name('my-trainings');
            Route::get('/training/{registrationId}', StudentTrainingDetail::class)->name('training-detail');
        });

        $adminMiddleware = ['auth', 'verified', 'role:admin|sub_admin'];
        if (class_exists('App\Http\Middleware\PermitOfMiddleware')) {
            $adminMiddleware[] = 'permit-of:can-manage-training-calendar';
        }

        Route::middleware($adminMiddleware)->name('admin.')->prefix('admin')->group(function () {
            Route::get('/trainings', AdminTrainingListing::class)->name('trainings');
            Route::get('/registrations', AdminRegistrationListing::class)->name('registrations');
            Route::get('/settings', ModuleSettings::class)->name('settings');
        });

        Route::get('/{training}', TrainingDetail::class)->name('detail');
    });
