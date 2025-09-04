<?php

$maxVideoSize = setting('_general.max_video_size');

return [
    'id'        => 'vision',
    'name'      => __('Vision'),
    'icon'      => '<i class="icon-tv"></i>',
    'tab'       => 'Common',
    'fields'    => [
        [
            'id'           => 'video',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Vision Video'),
            'label_desc'    => __('Add Video'),
            'max_size'      => $maxVideoSize ?? 5,               
            'ext'    => [
                'mp4',
                'mkv',
                'flv',
            ],
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
            'id'                => 'list_data',
            'type'              => 'repeater',
            'label_title'       => __('List data'),
            'repeater_title'    => __('List data'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'item_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Item heading'),
                    'placeholder'   => __('Enter heading'),
                ],
                [
                    'id'            => 'list_item',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Item description'),
                    'placeholder'   => __('Enter item'),
                ],
            ]
        ],
        [
            'id'            => 'discover_more_btn_url',
            'type'          => 'text',
            'value'         => "",
            'class'         => '',
            'label_title'   => __('Primary button url'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'discover_more_btn_text',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Primary button text'),
            'placeholder'   => __('Enter button text'),
        ],
    ]
];
