<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'achievements',
    'name'      => __('Achievements'),
    'icon'      => '<i class="icon-award"></i>',
    'tab'       => 'About-us',
    'fields'    => [
        [
            'id'            => 'shape_image',
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
            ], 
        ],
        [
            'id'            => 'shape_second_image',
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
            ], 
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
            'label_title'   => __('Pre Heading'),
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
            'id'                => 'repeater_data',
            'type'              => 'repeater',
            'label_title'       => __('Data'),
            'repeater_title'    => __('Data'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'icon',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Add icon'),
                    'placeholder'   => __('<i class="fa-solid fa-arrow-up-right-from-square"></i>'),
                ],
                [
                    'id'            => 'sub_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Sub heading'),
                    'placeholder'   => __('Enter sub heading'),
                ],
            ],
        ],
    ]
];
