<?php
if (!isActiveModule('coursebundles')) {
    return [];
}

$image_size = (int) (setting('_general.max_image_size') ?? '5');

return [
    'section' => [
        'id'     => '_coursebundle',
        'label'  => __('coursebundles::bundles.coursebundle_settings'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'comission_setting',
            'type'          => 'number',
            'min'           => '0',
            'max'           => '100',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('coursebundles::bundles.commission_settings'),
            'placeholder'   => __('coursebundles::bundles.commission_settings_placeholder'),
            'field_desc'    => __('coursebundles::bundles.commission_settings_desc'),
        ],
        [
            'id'            => 'clear_course_bundle_amount_after_days',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('coursebundles::bundles.clear_course_bundle_amount_after_days'),
            'placeholder'   => __('coursebundles::bundles.clear_course_bundle_amount_after_days_placeholder'),
            'field_desc'    => __('coursebundles::bundles.clear_course_bundle_amount_after_days_desc'),
        ],

        [
            'id'            => 'course_bundle_banner_image',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('coursebundles::bundles.course_bundle_banner_image'),
            'field_desc'    => __('coursebundles::bundles.course_bundle_banner_image_desc'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'course_bundle_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('coursebundles::bundles.course_bundle_heading'),
            'placeholder'   => __('coursebundles::bundles.course_bundle_heading_placeholder'),
            'field_desc'    => __('coursebundles::bundles.course_bundle_heading_desc'),
        ],
        [
            'id'            => 'course_bundle_description',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('coursebundles::bundles.course_bundle_description'),
            'placeholder'   => __('coursebundles::bundles.course_bundle_description_placeholder'),
            'field_desc'    => __('coursebundles::bundles.course_bundle_description_desc'),
        ],
    ]
];
