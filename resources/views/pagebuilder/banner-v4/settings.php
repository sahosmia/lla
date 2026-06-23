<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'banner-v4',
    'name'      => __('BannerV4'),
    'icon'      => '<i class="icon-credit-card"></i>',
    'tab'       => "Banners",
    'fields'    => [
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
            'id'            => 'primary_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Primary button URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'primary_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Primary button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'secondary_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Secondary button URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'secondary_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Secondary button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'                => 'banner_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Companies banner'),
            'repeater_title'    => __('Add image'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'banner_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Companies image'),
                    'label_desc'    => __('Add image'),
                    'max_size'      => $maxImageSize ?? 5,
                    'ext'    => [
                        'jpg',
                        'png',
                        'svg',
                        'jpeg',
                        'webp',
                    ]
                ]
            ]
        ],
        
        [
            'id'            => 'bg_img_one',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('First background image'),
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
            'id'            => 'bg_img_two',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Second background image'),
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
            'id'            => 'bg_img_three',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Third background image'),
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
            'id'            => 'bg_img_four',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Fourth background image'),
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
