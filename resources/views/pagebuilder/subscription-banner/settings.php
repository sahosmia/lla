<?php

$maxImageSize = setting('_general.max_image_size');

if(\Nwidart\Modules\Facades\Module::has('Subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('Subscriptions')) {
    return [
            'id'        => 'subscription-banner',
            'name'      => __('Subscription Banner'),
            'icon'      => '<i class="icon-credit-card"></i>',
            'tab'       => "Subscriptions",
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
                        'id'            => 'paragraph',
                        'type'          => 'editor',
                        'value'         => '',
                        'class'         => '',
                        'label_title'   => __('Description'),
                        'placeholder'   => __('Enter description'),
                    ],
                    [
                        'id'            => 'student_btn_url',
                        'type'          => 'text',
                        'value'         => '',
                        'class'         => '',
                        'label_title'   => __('Primary button url'),
                        'placeholder'   => __('Enter url'),
                    ],
                    [
                        'id'            => 'student_btn_txt',
                        'type'          => 'text',
                        'value'         => '',
                        'class'         => '',
                        'label_title'   => __('Primary button text'),
                        'placeholder'   => __('Enter button text'),
                    ],
                    [
                        'id'            => 'tutor_btn_url',
                        'type'          => 'text',
                        'value'         => '',
                        'class'         => '',
                        'label_title'   => __('Secondary button url'),
                        'placeholder'   => __('Enter url'),
                    ],
                    [
                        'id'            => 'tutor_btn_txt',
                        'type'          => 'text',
                        'value'         => '',
                        'class'         => '',
                        'label_title'   => __('Secondary button text'),
                        'placeholder'   => __('Enter button text'),
                    ],
                    [
                        'id'            => 'active_banner_btn',
                        'type'          => 'select',
                        'class'         => '',
                        'label_title'   => __('Active Banner Button'),
                        'options'       => [
                            'student'   => 'Student',
                            'tutor'     => 'Tutor',
                        ],
                        'default'       => 'student',  
                        'placeholder'   => __('Select from the list'),  
                    ],
                    [
                        'id'            => 'banner_image',
                        'type'          => 'file',
                        'class'         => '',
                        'label_title'   => __('Banner image'),
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
                    [
                        'id'            => 'cursor_image',
                        'type'          => 'file',
                        'class'         => '',
                        'label_title'   => __('Cursor image'),
                        'label_desc'    => __('Add cursor image'),
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
        ];
}
else {
    return [];
}