<?php

$maxVideoSize = setting('_general.max_video_size');
$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'banner',
    'name'      => __('Banner'),
    'icon'      => '<i class="icon-airplay"></i>',
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
            'id'            => 'search_placeholder',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Search placeholder'),
            'placeholder'   => __('Enter search placeholder'),
        ],
        [
            'id'            => 'image_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Image heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'image_paragraph',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Image description'),
            'placeholder'   => __('Enter description'),
        ],

        [
            'id'            => 'video',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Banner video'),
            'label_desc'    => __('Add video'),
            'max_size'      => $maxVideoSize ?? 10,            
            'ext'    => [
                'mp4',
                'flv',
                'webm',
            ], 
        ],

        [
            'id'            => 'tutors_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Primary image'),
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
            'id'            => 'student_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Secondary image'),
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
