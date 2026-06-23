<?php

return [
    'id'        => 'content-banner',
    'name'      => __('Content Banner'),
    'icon'      => '<i class="icon-book-open"></i>',
    'tab'       => "Banners",
    'fields'    => [
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
            'id'            => 'student_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button url'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'student_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'tutor_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button url'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'tutor_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button text'),
            'placeholder'   => __('Enter button text'),
        ],
    ]
];
