<?php

$maxImageSize = setting('_general.max_image_size');

return [
    'id' => 'training-calendars',
    'name' => __('Training Calendars'),
    'icon' => '<i class="icon-calendar"></i>',
    'tab' => 'Common',
    'fields' => [
        [
            'id' => 'section_title_variation',
            'type' => 'select',
            'class' => '',
            'label_title' => __('Section title variation'),
            'options' => [
                'am-section_title_one' => __('Classic'),
                'am-section_title_two' => __('Traditional'),
                'am-section_title_three' => __('Modern'),
            ],
            'default' => '',
        ],
        [
            'id' => 'pre_heading_text_color',
            'type' => 'colorpicker',
            'value' => '',
            'class' => '',
            'label_title' => __('Pre heading text color'),
        ],
        [
            'id' => 'pre_heading_bg_color',
            'type' => 'colorpicker',
            'value' => '',
            'class' => '',
            'label_title' => __('Pre heading bg color'),
        ],
        [
            'id' => 'pre_heading',
            'type' => 'text',
            'value' => '',
            'class' => '',
            'label_title' => __('Pre Heading'),
            'placeholder' => __('Enter pre heading'),
        ],
        [
            'id' => 'heading',
            'type' => 'text',
            'value' => '',
            'class' => '',
            'label_title' => __('Heading'),
            'placeholder' => __('Enter heading'),
        ],
        [
            'id' => 'paragraph',
            'type' => 'editor',
            'value' => '',
            'class' => '',
            'label_title' => __('Description'),
            'placeholder' => __('Enter description'),
        ],
        [
            'id' => 'trainings_limit',
            'type' => 'text',
            'value' => '6',
            'class' => '',
            'label_title' => __('Trainings limit'),
            'placeholder' => __('Enter trainings limit'),
        ],
    ],
];
