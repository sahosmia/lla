<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id'        => 'upcoming-events',
    'name'      => __('Upcoming Events'),
    'icon'      => '<i class="icon-calendar"></i>',
    'tab'       => "Common",
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
            'value'         => 'Upcoming Trainings & Events',
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
            'id'                => 'events_data',
            'type'              => 'repeater',
            'label_title'       => __('Events'),
            'repeater_title'    => __('Event'),
            'multi'             => true,
            'fields'       =>
            [
                [
                    'id'            => 'title',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Training Title'),
                    'placeholder'   => __('Enter title'),
                ],
                [
                    'id'            => 'date_time',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Date & Time'),
                    'placeholder'   => __('Enter date and time'),
                ],
                [
                    'id'            => 'mode',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('Mode'),
                    'options'       => [
                        'Online'    => __('Online'),
                        'Physical'  => __('Physical'),
                        'Hybrid'    => __('Hybrid'),
                        'Online (Live Session)' => __('Online (Live Session)'),
                        'Online / Classroom' => __('Online / Classroom'),
                        'Online / Physical' => __('Online / Physical'),
                    ],
                    'default'       => 'Online',
                ],
                [
                    'id'            => 'trainer_name',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Trainer Name'),
                    'placeholder'   => __('Enter trainer name'),
                ],
                [
                    'id'            => 'banner_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Banner Image'),
                    'label_desc'    => __('Add image (Landscape format recommended)'),
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
                    'id'            => 'registration_link',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Registration Link'),
                    'placeholder'   => __('Enter registration link'),
                ],
                [
                    'id'            => 'button_text',
                    'type'          => 'text',
                    'value'         => 'Register Now',
                    'class'         => '',
                    'label_title'   => __('Button Text'),
                    'placeholder'   => __('Enter button text'),
                ],
            ],
        ],
    ]
];
