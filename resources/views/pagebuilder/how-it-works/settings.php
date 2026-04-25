<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'how-it-works',
    'name'      => __('How it works'),
    'icon'      => '<i class="icon-tv"></i>',
    'tab'       => 'How-it-works',
    'fields'    => [
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
            'id'            => 'student_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Student button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'tutor_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Tutor button text'),
            'placeholder'   => __('Enter button text'),
        ],

        [                                                          
            'id'                => 'student_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Student data'),
            'repeater_title'    => __('Student data'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'std_btn_icon',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Add icon'),
                    'placeholder'   => __('<i class="fa-solid fa-arrow-up-right-from-square"></i>'),
                ],
                [
                    'id'            => 'student_sub_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Sub heading'),
                    'placeholder'   => __('Enter sub heading'),
                ],
                [
                    'id'            => 'student_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Heading'),
                    'placeholder'   => __('Enter heading'),
                ],
                [
                    'id'            => 'student_paragraph',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Description'),
                    'placeholder'   => __('Enter description'),
                ],
                [
                    'id'            => 'student_image',
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
                    ], 
                ],
            ]
        ],

        [                                                          
            'id'                => 'tutor_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Tutor data'),
            'repeater_title'    => __('Tutor data'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'tutor_btn_icon',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Add icon'),
                    'placeholder'   => __('<i class="fa-solid fa-arrow-up-right-from-square"></i>'),
                ],
                [
                    'id'            => 'tutor_sub_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Sub heading'),
                    'placeholder'   => __('Enter sub heading'),
                ],
                [
                    'id'            => 'tutor_heading',
                    'type'          => 'text',
                    'value'         => 'Fill in your details and set your learning preferences.',
                    'class'         => '',
                    'label_title'   => __('Heading'),
                    'placeholder'   => __('Enter heading'),
                ],
                [
                    'id'            => 'tutor_paragraph',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Description'),
                    'placeholder'   => __('Enter description'),
                ],
                [
                    'id'            => 'tutor_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Tutor image'),
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
        ],
    ]
];
