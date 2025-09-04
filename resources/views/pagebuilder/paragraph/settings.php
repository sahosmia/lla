<?php

return [
    'id' => 'paragraph',
    'name' => __('Paragraph'),
    'icon' => '<i class="icon-help-circle"></i>',
    'tab' => "Common",
    'fields' => [
        [
            'id'            => 'heading',
            'type'          => 'text',
            'value'         => 'Frequently asked questions',
            'class'         => '',
            'label_title'   => __('Heading'),
            'placeholder'   => __('Enter Heading'),
        ],
        [
            'id'            => 'paragraph',
            'type'          => 'editor',
            'value'         => "Find answers to your questions instantly. Need more guidance? Dive into our extensive documentation for all your queries.",
            'class'         => '',
            'label_title'   => __('Paragraph'),
            'placeholder'   => __('Enter paragraph'),
        ],
    ]
];
