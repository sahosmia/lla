<?php
if(\Nwidart\Modules\Facades\Module::has('Subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('Subscriptions')) {
    return [
        'id'        => 'subscriptions',
        'name'      => __('Subscriptions'),
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
                'id'                => 'subscriptions_for',
                'type'              => 'select',
                'class'             => '',
                'label_title'       => __('Show Subscriptions For'),
                'options'           => [
                    'student'   => 'Student',
                    'tutor'     => 'Tutor',
                ],
                'default'           => 'student',  
                'placeholder'       => __('Select from the list'),  
            ],
        ]
    ];
}
else {
    return [];
}