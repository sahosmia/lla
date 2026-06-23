<?php
if (!\Nwidart\Modules\Facades\Module::has('starup') || !\Nwidart\Modules\Facades\Module::isEnabled('starup')) {
    return [];
}
return [
    'section' => [
        'id'     => '_badges',
        'label'  => __('starup::starup.badges_settings'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'job_frequency',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('starup::starup.job_assignment_frequency'),
            'field_desc'   => __('starup::starup.job_assignment_frequency_desc'),
            'options'       => [
                'everyMinute'             => 'Every minute',
                'everyThirtyMinutes'      => 'Every 30 minutes',
                'hourly'                  => 'Hourly',
                'daily'                   => 'Daily',
                'weekly'                  => 'Weekly',
            ],
            'default'       => 'daily',
            'placeholder'   => __('settings.select_option'),
        ],

    ]
];
