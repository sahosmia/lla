<?php
if(\Nwidart\Modules\Facades\Module::has('Subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('Subscriptions')) {
return [
    'id'        => 'subscription-faqs',
    'name'      => __('Subscription FAQs'),
    'icon'      => '<i class="icon-help-circle"></i>',
    'tab'       => "Subscriptions",
    'fields'    => [
        [
            'id'            => 'sub_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Sub heading'),
            'placeholder'   => __('Enter sub heading'),
        ],
        [
            'id'            => 'heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Heading'),
            'placeholder'   => __('Enter Heading'),
        ],
        [
            'id'            => 'paragraph',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Paragraph'),
            'placeholder'   => __('Enter paragraph'),
        ],
        [
            'id'                => 'faqs_data',
            'type'              => 'repeater',
            'label_title'       => __('FAQs contents'),
            'repeater_title'    => __('FAQ'),
            'multi'             => true,
            'fields'       =>
            [
                [
                    'id'            => 'question',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Question'),
                    'placeholder'   => __('Enter question'),
                ],
                [
                    'id'            => 'answer',
                    'type'          => 'text',
                    'value'         => '',
                    'label_title'   => __('Answer'),
                    'placeholder'   => __('Enter answer'),
                ],
               
            ],
        ],
    ]
    ];
}
else {
    return [];
}