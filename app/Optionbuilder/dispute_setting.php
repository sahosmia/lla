<?php
return [
    'section' => [
        'id'     => '_dispute_setting',
        'label'  => __('settings.dispute_setting'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'                => 'dispute_reasons',
            'type'              => 'repeater',
            'tab_id'            => 'dispute_setting',
            'tab_title'         => __('settings.dispute_setting'),
            'label_title'       => __('settings.dispute_reasons'),
            'repeater_title'    => __('settings.add_dispute_reason'),
            'multi'       => true,
            'fields'       =>[
                [
                    'id'            => 'dispute_reason',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('settings.add_dispute_reason'),
                    'placeholder'   => __('settings.enter_dispute_reason'),
                ],
            ]
        ],
        [
            'id'            => 'dispute_message',
            'type'          => 'text',
            'tab_id'        => 'dispute_setting',
            'tab_title'     => __('settings.dispute_setting'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.dispute_message'),
            'placeholder'   => __('settings.add_dispute_message'),
        ],
        [
            'id'            => 'dispute_winner_message',
            'type'          => 'text',
            'tab_id'        => 'dispute_setting',
            'tab_title'     => __('settings.dispute_setting'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.dispute_winner_message'),
            'placeholder'   => __('settings.add_dispute_winner_message'),
        ],
        [
            'id'            => 'dispute_loser_message',
            'type'          => 'text',
            'tab_id'        => 'dispute_setting',
            'tab_title'     => __('settings.dispute_setting'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.dispute_loser_message'),
            'placeholder'   => __('settings.add_dispute_loser_message'),
        ],
        [
            'id'            => 'pending_dispute_tooltip_message',
            'type'          => 'text',
            'tab_id'        => 'dispute_setting',
            'tab_title'     => __('settings.dispute_setting'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.pending_dispute_tooltip_message'),
            'placeholder'   => __('settings.add_dispute_tooltip_message'),
        ],
        [
            'id'            => 'close_dispute_tooltip_message',
            'type'          => 'text',
            'tab_id'        => 'dispute_setting',
            'tab_title'     => __('settings.dispute_setting'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.close_dispute_tooltip_message'),
            'placeholder'   => __('settings.add_dispute_tooltip_message'),
        ],
        
    ]
];
