<?php
if (!isActiveModule('assignments')) {
    return [];
}

$image_size = (int) (setting('_general.max_image_size') ?? '5');

return [
    'section' => [
        'id'     => '_assignments',
        'label'  => __('assignments::assignments.assignments_settings'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'attempt_assignment_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('assignments::assignments.attempt_assignment_heading'),
            'placeholder'   => __('assignments::assignments.enter_heading_placeholder'),
            'field_desc'    => __('assignments::assignments.attempt_assignment_heading_desc'),
        ],
        [
            'id'            => 'assignment_banner_image',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('assignments::assignments.assignment_banner_image'),
            'field_desc'    => __('assignments::assignments.assignment_banner_image_desc'),
            'max_size'   => $image_size,             
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ],
        ],
    ]
];
