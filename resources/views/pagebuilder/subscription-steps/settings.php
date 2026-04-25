<?php

$maxImageSize = setting('_general.max_image_size');

if(\Nwidart\Modules\Facades\Module::has('Subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('Subscriptions')) {
    return [
        'id'        => 'subscription-steps',
        'name'      => __('Subscription Steps'),
        'icon'      => '<i class="icon-layers"></i>',
        'tab'       => "Subscriptions",
        'fields'    => [
            [
                'id'                => 'pre_heading',
                'type'              => 'text',
                'value'             => '',
                'class'             => '',
                'label_title'       => __('Pre Heading'),
                'placeholder'       => __('Enter pre heading'),
            ],
            [
                'id'                => 'heading',
                'type'              => 'text',
                'value'             => 'Demo heading',
                'class'             => '',
                'label_title'       => __('Heading'),
                'placeholder'       => __('Enter heading'),
            ],
            [
                'id'                => 'paragraph',
                'type'              => 'editor',
                'value'             => '',
                'class'             => '',
                'label_title'       => __('Description'),
                'placeholder'       => __('Enter description'),
            ],
            [
                'id'                => 'btn_url',
                'type'              => 'text',
                'value'             => '',
                'class'             => '',
                'label_title'       => __('Button url'),
                'placeholder'       => __('Enter url'),
            ],
            [
                'id'                => 'btn_txt',
                'type'              => 'text',
                'value'             => '',
                'class'             => '',
                'label_title'       => __('Button text'),
                'placeholder'       => __('Enter text'),
            ],
            [                                                          
                'id'                => 'steps_data',
                'type'              => 'repeater',
                'label_title'       => __('Steps data'),
                'repeater_title'    => __('Step'),
                'multi'             => true,
                'fields'            => [
                    [
                        'id'            => 'sub_heading',
                        'type'          => 'text',
                        'value'         => '',
                        'class'         => '',
                        'label_title'   => __('Sub heading'),
                        'placeholder'   => __('Enter sub heading'),
                    ],
                    [
                        'id'            => 'step_image',
                        'type'          => 'file',
                        'class'         => '',
                        'label_title'   => __('Step image'),
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
                        'id'            => 'step_heading',
                        'type'          => 'text',
                        'value'         => 'Demo step heading',
                        'class'         => '',
                        'label_title'   => __('Step heading'),
                        'placeholder'   => __('Enter heading'),
                    ],
                    [
                        'id'            => 'step_paragraph',
                        'type'          => 'editor',
                        'value'         => 'Demo step description',
                        'class'         => '',
                        'label_title'   => __('Step description'),
                        'placeholder'   => __('Enter description'),
                    ],
                ]
            ],
            [
                'id'            => 'shape_img',
                'type'          => 'file',
                'class'         => '',
                'label_title'   => __('Shape image'),
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
        ]
    ];
} else {
    return [];
}
