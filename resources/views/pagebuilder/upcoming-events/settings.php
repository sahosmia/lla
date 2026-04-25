<?php

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
            'id'            => 'events_limit',
            'type'          => 'text',
            'value'         => '6',
            'class'         => '',
            'label_title'   => __('Events Limit'),
            'placeholder'   => __('Enter events limit'),
        ],
    ]
];
