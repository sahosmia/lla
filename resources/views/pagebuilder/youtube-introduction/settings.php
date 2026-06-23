<?php

return [
    'id'        => 'youtube-introduction',
    'name'      => __('YouTube Introduction'),
    'icon'      => '<i class="icon-video"></i>',
    'tab'       => "Common",
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
            'id'            => 'description',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Description'),
            'placeholder'   => __('Enter description'),
        ],
        [
            'id'            => 'button_text',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'button_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button URL'),
            'placeholder'   => __('Enter button URL'),
        ],
        [
            'id'            => 'youtube_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('YouTube video URL'),
            'placeholder'   => __('Enter YouTube video URL'),
        ],
    ]
];
