<?php

return [
    'id'        => 'faqs',
    'name'      => __('FAQ'),
    'icon'      => '<i class="icon-help-circle"></i>',
    'tab'       => "Common",
    'fields'    => [
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
            'id'                => 'students_faqs_data',
            'type'              => 'repeater',
            'label_title'       => __('FAQs for students'),
            'repeater_title'    => __('FAQ'),
            'multi'             => true,
            'fields'       =>
            [
                [
                    'id'            => 'question',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Question'),
                    'placeholder'   => __('Enter question'),
                ],
                [
                    'id'            => 'answer',
                    'type'          => 'text',
                    'value'         => '',
                    'label_title'   => __('Answer'),
                    'placeholder'   => __('Enter answer'),
                ],
               
            ],
        ],
        [
            'id'                => 'tutors_faqs_data',
            'type'              => 'repeater',
            'label_title'       => __('FAQs for tutors'),
            'repeater_title'    => __('FAQ'),
            'multi'             => true,
            'fields'       =>
            [
                [
                    'id'            => 'question',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Question'),
                    'placeholder'   => __('Enter question'),
                ],
                [
                    'id'            => 'answer',
                    'type'          => 'text',
                    'value'         => '',
                    'label_title'   => __('Answer'),
                    'placeholder'   => __('Enter answer'),
                ],
               
            ],
        ]

    ]
];
