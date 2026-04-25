<?php
if (!\Nwidart\Modules\Facades\Module::has('spacekonnect') || !\Nwidart\Modules\Facades\Module::isEnabled('spacekonnect')) {
    return [];
}
return [
    'section' => [
        'id'     => '_space',
        'label'  => __('spacekonnect::spacekonnect.dospace_setting'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'space_enabled',
            'type'          => 'switch',
            'tab_title'     => __('spacekonnect::spacekonnect.storage_settings'),
            'class'         => '',
            'label_title'   => __('spacekonnect::spacekonnect.do_space_status'),
            'field_desc'    => __('spacekonnect::spacekonnect.do_space_status_desc'),
            'value'         => 'on',
        ],
        [
            'id'            => 'access_key_id',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('spacekonnect::spacekonnect.access_key_id'),
            'placeholder'   => __('spacekonnect::spacekonnect.access_key_id_placeholder'),
        ],
        [
            'id'            => 'secret_access_key',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('spacekonnect::spacekonnect.secret_access_key'),
            'placeholder'   => __('spacekonnect::spacekonnect.secret_access_key_placeholder'),
        ],
        [
            'id'            => 'default_region',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('spacekonnect::spacekonnect.default_region'),
            'field_desc'   => __('spacekonnect::spacekonnect.default_region_desc'),
            'options' => [
                'ams3' => 'AMS3',
                'blr1' => 'BLR1',
                'fra1' => 'FRA1',
                'lon1' => 'LON1',
                'nyc3' => 'NYC3',
                'sgp1' => 'SGP1',
                'sfo2' => 'SFO2',
                'sfo3' => 'SFO3',
                'syd1' => 'SYD1',
                'tor1' => 'TOR1',
            ],

        ],
        [
            'id'            => 'bucket_name',
            'type'          => 'text',
            'class'         => '',
            'label_title'   => __('spacekonnect::spacekonnect.bucket_name'),
            'placeholder'   => __('spacekonnect::spacekonnect.bucket_name_placeholder'),
        ],

    ]
];
