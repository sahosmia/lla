<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'easy-steps',
    'name'      => __('Easy steps'),
    'icon'      => '<i class="icon-clipboard"></i>',
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
            'id'            => 'pre_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Pre heading'),
            'placeholder'   => __('Enter pre heading'),
        ],
        [
            'id'            => 'heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'paragraph',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Description'),
            'placeholder'   => __('Enter description'),
        ],
        [
            'id'            => 'shape_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Shape image'),
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
            'id'                => 'steps_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Easy steps'),
            'repeater_title'    => __('Add step'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'step_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Step gif'),
                    'label_desc'    => __('Add gif'),
                    'max_size'      => $maxImageSize ?? 5,                  
                    'ext'    => [
                        'gif',
                    ]
                ],
                [
                    'id'            => 'scnd_step_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Step image'),
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
                    'id'            => 'image_verient',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('Select verient'),
                    'options'       => [
                        'am-step-warning'        => 'Yellow',
                        'am-step-primary'        => 'Blue',
                        'am-step-success'        => 'Green',
                        'am-step_danger'         => 'Red',
                    ],
                    'default'       => 'non',  
                    'placeholder'   => __('settings.select_from_list'),  
                ],
                [
                    'id'            => 'step_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Heading'),
                    'placeholder'   => __('Enter heading'),
                ],
                [
                    'id'            => 'step_paragraph',
                    'type'          => 'editor',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Description'),
                    'placeholder'   => __('Enter description'),
                ],
                [
                    'id'            => 'learn_more_btn_url',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Learn more button URL'),
                    'placeholder'   => __('Enter url'),
                ],
                [
                    'id'            => 'learn_more_btn_txt',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Learn more button text'),
                    'placeholder'   => __('Enter button text'),
                ],
            ]
        ],
        [
            'id'            => 'style_variation',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Style variation'),
            'options'       => [
                ''                              => __('Select style'),
                'easy-steps-variation-one'      => __('Style V1'),
                'easy-steps-variation-two'      => __('Style V2'),
                'easy-steps-variation-three'    => __('Style V3'),
            ],
            'default'       => '',
            'placeholder'   => __('settings.select_from_list'),
        ],
    ]
];
