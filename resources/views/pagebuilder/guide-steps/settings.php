<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'guide-steps',
    'name'      => __('Guide Steps'),
    'icon'      => '<i class="icon-layers"></i>',
    'tab'       => "Common",
    'fields'    => [
        [
            'id'            => 'section_title_variation',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Section title variation'),
            'options'       => [
                'am-section_title_one'      => __('Classic'),
                'am-section_title_two'      => __('Traditional'),
                'am-section_title_three'    => __('Modern'),
            ],
            'default'       => '',
        ],
        [
            'id'            => 'pre_heading_text_color',
            'type'          => 'colorpicker',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Pre heading text color'),
            // 'field_desc'    => __('settings.pre_heading_text_color_desc'),
        ],
        [
            'id'            => 'pre_heading_bg_color',
            'type'          => 'colorpicker',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Pre heading bg color'),
            // 'field_desc'    => __('settings.pre_heading_text_color_desc'),
        ],
        [
            'id'                => 'pre_heading',
            'type'              => 'text',
            'value'             => '',
            'class'             => '',
            'label_title'       => __('Pre Heading'),
            'placeholder'       => __('Enter pre heading'),
        ],
        [
            'id'                => 'heading',
            'type'              => 'text',
            'value'             => '',
            'class'             => '',
            'label_title'       => __('Heading'),
            'placeholder'       => __('Enter heading'),
        ],
        [
            'id'                => 'paragraph',
            'type'              => 'editor',
            'value'             => '',
            'class'             => '',
            'label_title'       => __('Description'),
            'placeholder'       => __('Enter description'),
        ],

        [                                                          
            'id'                => 'steps_data',
            'type'              => 'repeater',
            'label_title'       => __('Steps data'),
            'repeater_title'    => __('Step'),
            'multi'             => true,
            'fields'            => [
                [
                    'id'            => 'step_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Step heading'),
                    'placeholder'   => __('Enter step heading'),
                ],
                [
                    'id'            => 'step_paragraph',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Step paragraph'),
                    'placeholder'   => __('Enter step paragraph'),
                ],
                [
                    'id'                => 'step_icon',
                    'type'              => 'text',
                    'value'             => '',
                    'class'             => '',
                    'label_title'       => __('Step icon'),
                    'placeholder'       => __('<i class="fa-solid fa-arrow-up-right-from-square"></i>'),
                ],
            ]
        ],
        [
            'id'            => 'first_shape_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('First shape image'),
            'label_desc'    => __('Add image'),
            'max_size'      => $maxImageSize ?? 5,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
                'jpeg',
                'webp',
            ]
        ],
        [
            'id'            => 'second_shape_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Second shape image'),
            'label_desc'    => __('Add image'),
            'max_size'      => $maxImageSize ?? 5,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
                'jpeg',
                'webp',
            ]
        ],
        [
            'id'            => 'main_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Main image'),
            'label_desc'    => __('Add image'),
            'max_size'      => $maxImageSize ?? 5,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
                'jpeg',
                'webp',
            ]
        ],
        [
            'id'                => 'primary_btn_url',
            'type'              => 'text',
            'value'             => '',
            'class'             => '',
            'label_title'       => __('Primary button url'),
            'placeholder'       => __('Enter url'),
        ],
        [
            'id'                => 'primary_btn_text',
            'type'              => 'text',
            'value'             => '',
            'class'             => '',
            'label_title'       => __('Primary button text'),
            'placeholder'       => __('Enter button text'),
        ],
        [
            'id'                => 'secondary_btn_url',
            'type'              => 'text',
            'value'             => '',
            'class'             => '',
            'label_title'       => __('Secondary button url'),
            'placeholder'       => __('Enter url'),
        ],
        [
            'id'                => 'secondary_btn_text',
            'type'              => 'text',
            'value'             => '',
            'class'             => '',
            'label_title'       => __('Secondary button text'),
            'placeholder'       => __('Enter button text'),
        ],
    ]
];
