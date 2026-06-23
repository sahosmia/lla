<?php

return [
    'section' => [
        'id'     => '_social',
        'label'  => __('settings.social_settings'),
        'icon'   => '',
    ],
    'fields' => [
        [
          'id'            => 'platforms',
          'type'          => 'select',
          'class'         => '',
          'multi'         => true,
          'label_title'   => __('settings.social_platforms'),
          'options'       => [
                'Facebook' => 'Facebook',
                'X/Twitter'           => 'X/Twitter',
                'LinkedIn'    => 'LinkedIn',
                'Instagram'   => 'Instagram',
                'Pinterest'   => 'Pinterest',
                'YouTube'     => 'YouTube',
                'TikTok'      => 'TikTok',
                'WhatsApp'    => 'WhatsApp',
          ],
          'placeholder'   => __('settings.select_from_list'),   
      ]
    ]
];
