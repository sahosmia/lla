<?php

$images_size = (int) (setting('_general.max_image_size') ?? '5');

return [
    'section' => [
        'id'     => '_maintenance',
        'label'  => __('admin/sidebar.maintenance'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'maintenance_mode',
            'type'          => 'radio',
            'label_title'   => __('settings.maintenance_mode'),
            'field_desc'    => __('settings.maintenance_mode_desc'),
            'placeholder'   => __('settings.enter_value'),
            'options'       => [
                'Yes' => 'Yes',
                'No' => 'No',
            ],
            'default'       => 'No',
        ],
        [
            'id'            => 'maintenance_logo',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('admin/optionbuilder.maintenance_logo'),
            'field_desc'    => __('admin/optionbuilder.image_option', ['extension' => 'jpg, png', 'size' => $images_size . 'mb']),
            'max_size'   => $images_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'maintenance_title',
            'type'          => 'text',

            'class'         => '',
            'label_title'   => __('admin/optionbuilder.maintenance_title'),
            'field_desc'    => __('admin/optionbuilder.maintenance_title_desc'),
            'placeholder'   => __('admin/optionbuilder.maintenance_title'),
        ],
        [
            'id'            => 'maintenance_description',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('admin/optionbuilder.maintenance_description'),
            'field_desc'    => __('admin/optionbuilder.maintenance_description_desc'),
            'placeholder'   => __('admin/optionbuilder.maintenance_description'),
        ],
        [
            'id'            => 'maintenance_email',
            'type'          => 'text',

            'value'         => '',
            'class'         => '',
            'label_title'   => __('admin/optionbuilder.maintenance_email'),
            'field_desc'    => __('admin/optionbuilder.maintenance_email_desc'),
            'placeholder'   => __('admin/optionbuilder.maintenance_email'),
        ],

    ]
];
