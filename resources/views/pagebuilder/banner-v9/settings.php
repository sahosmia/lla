<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'banner-v9',
    'name'      => __('BannerV9'),
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
            'id'            => 'all_tutor_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Primary button url'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'all_tutor_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Primary button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Banner image'),
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
            'id'            => 'brand_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Brand heading'),
            'placeholder'   => __('Enter brand heading'),
        ],
        [
            'id'                => 'banner_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Companies images'),
            'repeater_title'    => __('Add image'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'banner_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Company image'),
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
    ]
];
