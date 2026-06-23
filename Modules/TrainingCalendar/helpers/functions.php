<?php

if (!function_exists('trainingCalendarSetting')) {
    function trainingCalendarSetting(string $key, mixed $default = null): mixed
    {
        return setting('_training_calendar.' . $key) ?? $default;
    }
}

if (!function_exists('trainingCalendarMenuOptions')) {
    function trainingCalendarMenuOptions(string $role): array
    {
        switch ($role) {
            case 'tutor':
                return [[
                    'tutorSortOrder' => 5,
                    'route' => 'trainingcalendar.tutor.trainings',
                    'onActiveRoute' => [
                        'trainingcalendar.tutor.trainings',
                        'trainingcalendar.tutor.create',
                        'trainingcalendar.tutor.edit',
                        'trainingcalendar.tutor.registrations',
                        'trainingcalendar.tutor.send-notice',
                    ],
                    'title' => __('trainingcalendar::trainingcalendar.menu_tutor'),
                    'icon' => '<i class="am-icon-calender-day"></i>',
                    'accessibility' => ['tutor'],
                    'disableNavigate' => true,
                ]];
            case 'student':
                return [
                    [
                        'studentSortOrder' => 4,
                        'route' => 'trainingcalendar.student.my-trainings',
                        'onActiveRoute' => ['trainingcalendar.student.my-trainings', 'trainingcalendar.student.training-detail'],
                        'title' => __('trainingcalendar::trainingcalendar.menu_student'),
                        'icon' => '<i class="am-icon-calender-day"></i>',
                        'accessibility' => ['student'],
                        'disableNavigate' => true,
                    ],
                ];
            case 'admin':
                return [[
                    'title' => __('trainingcalendar::trainingcalendar.menu_admin'),
                    'icon' => 'icon-calendar',
                    'permission' => 'can-manage-training-calendar',
                    'routes' => [
                        'trainingcalendar.admin.trainings' => __('trainingcalendar::trainingcalendar.all_trainings'),
                        'trainingcalendar.admin.registrations' => __('trainingcalendar::trainingcalendar.all_registrations'),
                        'trainingcalendar.admin.settings' => __('trainingcalendar::trainingcalendar.module_settings'),
                    ],
                ]];
            default:
                return [];
        }
    }
}

if (!function_exists('isTrainingCalendarModuleEnabled')) {
    function isTrainingCalendarModuleEnabled(): bool
    {
        return \Nwidart\Modules\Facades\Module::has('TrainingCalendar')
            && \Nwidart\Modules\Facades\Module::isEnabled('TrainingCalendar');
    }
}
