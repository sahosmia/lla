<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'why-choose-us',
    'name'      => __('Why choose us'),
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
            'id'                => 'steps_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Why choose us data'),
            'repeater_title'    => __('Add data'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Data image'),
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
                    'id'            => 'data_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Data heading'),
                    'placeholder'   => __('Enter heading'),
                ],
                [
                    'id'            => 'data_description',
                    'type'          => 'editor',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Data description'),
                    'placeholder'   => __('Enter description'),
                ],
            ]
        ],
        [
            'id'            => 'btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Primary button url'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Primary button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'bg_shape_img',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Background shape image'),
            'label_desc'    => __('Add image'),
            'max_size'      => $maxImageSize ?? 5,
            'ext'    => [
                'jpg',
                'png',
                'svg',
                'jpeg',
                'webp',
            ],
        ],
    ]
];
