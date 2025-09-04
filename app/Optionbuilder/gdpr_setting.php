<?php

$image_size = (int) (setting('_general.max_image_size') ?? '5');

return [
    'section' => [
        'id'     => '_gdpr',
        'label'  => __('admin/sidebar.gdpr'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'enable_gdpr',
            'type'          => 'switch',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.gdpr_label'),
            'field_desc'    => __('settings.gdpr_desc'),
            'value'         => '1',
        ],
        [
            'id'            => 'gdpr_logo',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('settings.gdpr_logo'),
            'field_desc'    => __('settings.add_gdpr_logo'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ],
        ],
        [
            'id'            => 'gdpr_title',
            'type'          => 'text',
            'class'         => '',
            'label_title'   => __('settings.gdpr_title'),
            'field_desc'    => __('settings.gdpr_title_desc'),
            'placeholder'   => __('settings.gdpr_title'),
        ],
        [
            'id'            => 'gdpr_description',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.gdpr_description'),
            'field_desc'    => __('settings.gdpr_description_desc'),
            'placeholder'   => __('settings.gdpr_description'),
        ]
    ]
];
