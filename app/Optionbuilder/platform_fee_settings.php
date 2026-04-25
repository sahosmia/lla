<?php

return [
    'section' => [
        'id'     => '_platform_fee',
        'label'  => __('admin/sidebar.platform_fee'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'platform_fee_title',
            'type'          => 'text',
            'class'         => '',
            'label_title'   => __('settings.platform_fee_title'),
            'field_desc'    => __('settings.platform_fee_title_desc'),
            'placeholder'   => __('settings.platform_fee_title_placeholder'),
        ],
        [
            'id'            => 'platform_fee',
            'type'          => 'text',
            'class'         => '',
            'label_title'   => __('settings.platform_fee'),
            'field_desc'    => __('settings.platform_fee_desc'),
            'placeholder'   => __('settings.platform_fee_placeholder'),
        ],
    ]
];
