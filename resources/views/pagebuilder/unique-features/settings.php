<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'unique-features',
    'name'      => __('Unique Features'),
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
            'id'            => 'select_verient',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select title verient'),
            'options'       => [
                'unique-features-varient-one'        => 'Style V1',
                'unique-features-varient-two'        => 'Style V2',
                'unique-features-varient-three'      => 'Style V3',
            ],
            'default'       => '',  
            'placeholder'   => __('settings.select_from_list'),  
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
        // 1st section
        [
            'id'            => 'section1_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Section one heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'section1_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section one first image'),
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
            'id'            => 'section1_2nd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section one second image'),
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
        // end 1st section

        // 2nd section
        [
            'id'            => 'section2_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Section two heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'section2_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section two first image'),
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
            'id'            => 'section2_2nd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section two second image'),
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
            'id'            => 'section2_3rd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section two third image'),
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
            'id'            => 'section2_4th_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section two fourth image'),
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
        // end 2nd section

        // 3rd section
        [
            'id'            => 'section3_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Section third heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'section3_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section three first image'),
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
            'id'            => 'section3_2nd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section three second image'),
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
            'id'            => 'section3_3rd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section three third image'),
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
        // end 3rd section

        // 4tt section
        [
            'id'            => 'section4_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Section fourth heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'section4_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section four first image'),
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
            'id'            => 'section4_2nd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Section four second image'),
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
        // end 4tt section

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
        [
            'id'            => 'shape_img',
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
            ],
        ],
    ]
];
