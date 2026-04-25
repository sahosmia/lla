<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'banner-v8',
    'name'      => __('BannerV8'),
    'icon'      => '<i class="icon-credit-card"></i>',
    'tab'       => "Banners",
    'fields'    => [
        [
            'id'                => 'banner_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Banner data'),
            'repeater_title'    => __('Add banner data'),
            'multi'             => true,
            'fields'       => [
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
                    'id'            => 'bg_image_one',
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
                    ]
                ],
                [
                    'id'            => 'bg_image_two',
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
                    ]
                ],
                [
                    'id'            => 'bg_image_three',
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
                    ]
                ],
                [
                    'id'            => 'companies_images',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Companies images'),
                    'label_desc'    => __('Add images'),
                    'max_size'      => $maxImageSize ?? 5,
                    'multi'         => true,
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
