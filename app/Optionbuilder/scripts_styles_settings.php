<?php


return [
    'section' => [
        'id'     => '_scripts_styles',
        'label'  => __('sidebar.script_style_settings'),
        'tabs'   => false,
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'header_scripts',
            'type'          => 'textarea',
            'tab_id'        => '',
            'tab_title'     => __('sidebar.script_style_settings'),
            'class'         => '',
            'label_title'   => __('settings.header_scripts'),
            'field_desc'    => __('settings.header_scripts_desc'),
            'value'         => '',
        ],
        [
            'id'            => 'footer_scripts',
            'type'          => 'textarea',
            'tab_id'        => '',
            'tab_title'     => __('sidebar.script_style_settings'),
            'class'         => '',
            'label_title'   => __('settings.footer_scripts'),
            'field_desc'    => __('settings.footer_scripts_desc'),
            'value'         => '',
        ],
        [
            'id'            => 'custom_styles',
            'type'          => 'textarea',
            'tab_id'        => '',
            'tab_title'     => __('sidebar.script_style_settings'),
            'class'         => '',
            'label_title'   => __('settings.custom_styles'),
            'field_desc'    => __('settings.custom_styles_desc'),
            'value'         => '',
        ],
    ]
];
