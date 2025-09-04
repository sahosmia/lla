<?php
if (!\Nwidart\Modules\Facades\Module::has('forumwise') || !\Nwidart\Modules\Facades\Module::isEnabled('forumwise')) {
    return [];
}

$image_size = (int) (setting('_general.max_image_size') ?? '5');

return [
    'section' => [
        'id'     => '_forum_wise',
        'label'  => __('sidebar.forums'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'fw_heading',
            'type'          => 'text',
            'tab_id'        => 'forum_settings',
            'tab_title'     => __('Forum Wise'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'fw_paragraph',
            'type'          => 'editor',
            'tab_id'        => 'forum_settings',
            'tab_title'     => __('Forum Wise'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Description'),
            'placeholder'   => __('Enter description'),
        ],

        [
            'id'            => 'fw_btn_txt',
            'type'          => 'text',
            'tab_id'        => 'forum_settings',
            'tab_title'     => __('Forum Wise'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Serach button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'fw_shape_image',
            'type'          => 'file',
            'tab_id'        => 'forum_settings',
            'tab_title'     => __('Forum Wise'),
            'class'         => '',
            'label_title'   => __('Shape image'),
            'max_size'      => $image_size,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
        [
            'id'            => 'fw_left_shape_image',
            'type'          => 'file',
            'tab_id'        => 'forum_settings',
            'tab_title'     => __('Forum Wise'),
            'class'         => '',
            'label_title'   => __('Left shape image'),
            'max_size'      => $image_size,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
        [
            'id'            => 'fw_right_shape_image',
            'type'          => 'file',
            'tab_id'        => 'forum_settings',
            'tab_title'     => __('Forum Wise'),
            'class'         => '',
            'label_title'   => __('Right shape image'),
            'max_size'      => $image_size,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
    ]
];
