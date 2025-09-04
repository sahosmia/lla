<?php
if (!isActiveModule('courses')) {
    return [];
}

return [
    'section' => [
        'id'     => '_course',
        'label'  => __('courses::courses.course_settings'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'allow_video_types',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'multi'         => true,
            'label_title'   => __('settings.allow_video_types'),
            'field_desc'    => __('settings.allow_video_types_desc'),
            'options'       => 
                                [
                                    'video_file'    => __('settings.allow_video_types_opt_video_file'),
                                    'youtube_link'  => __('settings.allow_video_types_opt_youtube_link'),
                                    'vimeo_link'    => __('settings.allow_video_types_opt_vimeo_link'),
                                ],
            'placeholder'   => __('settings.select_from_list'),
        ],
    ]
];
