<?php

use Illuminate\Support\Facades\DB;

$all_site_pages = [];

$image_size = (int) (setting('_general.max_image_size') ?? '5');
$video_size = (int) (setting('_general.max_video_size') ?? '10');
$file_size  = (int) (setting('_general.max_file_size') ?? '20');

$currencies     = currencyList();
$all_currencies = $per_page_rec = $all_site_pages = $all_payment_methods = [];

foreach (perPageOpt() as $key => $single) {
    $per_page_rec[$single] = $single;
}

foreach ($currencies as $key => $single) {
    $all_currencies[$key] = $single['name'] . ' (' . $single['symbol'] . ')';
}

$site_pages = DB::table(config('pagebuilder.db_prefix') . 'pages')
    ->select('id', 'name')
    ->where('status', 'published')
    ->get();
DB::disconnect();

if (!empty($site_pages)) {
    foreach ($site_pages as  $single) {
        $all_site_pages[$single->id] = $single->name;
    }
}

$ltu_languages = ['' => 'Select language'];

$languages = DB::table('languages')->get();
DB::disconnect();
foreach ($languages as $single) {
    $ltu_languages[$single->code] = $single->name;
}

$timezones = [
    '' => 'Select timezone'
];

foreach (timezone_identifiers_list() as $tz) {
    $timezones[$tz] = $tz;
}

$settings =  [
    'section' => [
        'id'     => '_general',
        'label'  => __('sidebar.general_settings'),
        'tabs'   => true,
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'default_language',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.default_language'),
            'options'       => $ltu_languages,
            'default'       => 'en',
            'placeholder'   => __('settings.select_from_list'),
        ],
        [
            'id'            => 'enable_multi_language',
            'type'          => 'switch',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.multi_language_label'),
            'field_desc'    => __('settings.multi_language_desc'),
            'value'         => '1',
        ],
        [
            'id'            => 'multi_language_list',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'multi'         => true,
            'label_title'   => __('settings.multi_language_select'),
            'label_desc'    => __('settings.multi_language_select_desc'),
            'field_desc'    => __('settings.multi_language_select_desc'),
            'options'       => $ltu_languages,
            'default'       => ['en'],
            'placeholder'   => __('settings.select_from_list'),
        ],
        [
            'id'            => 'enable_multi_currency',
            'type'          => 'switch',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.multi_currency_label'),
            'field_desc'    => __('settings.multi_currency_desc'),
            'value'         => '1',
        ],
        [
            'id'            => 'base_currency',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.base_currency_select'),
            'field_desc'    => __('settings.base_currency_select_desc'),
            'options'       => $all_currencies,
            'placeholder'   => __('settings.select_option'),
        ],
        [
            'id'            => 'currency_position',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.currency_position'),
            'options'       => [
                'left'          => __('settings.left'),
                'right'         => __('settings.right'),
                'left_space'    => __('settings.left_space'),
                'right_space'   => __('settings.right_space'),
            ],
            'default'       => 'left',
            'placeholder'   => __('settings.select_option'),
        ],
        [
            'id'                => 'multi_currency_list',
            'type'              => 'repeater',
            'tab_id'            => 'general_tab',
            'tab_title'         => __('settings.general'),
            'label_title'       => __('settings.multi_currency_select'),
            'repeater_title'    => __('settings.multi_currency_select'),
            'multi'             => true,
            'fields'            => [
                [
                    'id'            => 'code',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('settings.currency'),
                    'label_desc'    => __('settings.multi_currency_select_desc'),
                    'options'       => $all_currencies,
                    'placeholder'   => __('settings.select_option'),
                ],
                [
                    'id'            => 'conversion_rate',
                    'type'          => 'number',
                    'class'         => '',
                    'label_title'   => __('settings.exchange_rate'),
                    'value'         => '1.00',
                    'placeholder'   => __('settings.enter_exchange_rate'),
                ],
            ]
        ],

        [
            'id'            => 'enable_rtl',
            'type'          => 'switch',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.rtl_label'),
            'field_desc'    => __('settings.rtl_desc'),
            'value'         => '1',
        ],
        [
            'id'            => 'site_name',
            'type'          => 'text',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'value'         => env('APP_NAME'),
            'class'         => '',
            'label_title'   => __('settings.site_name'),
            'placeholder'   => __('settings.enter_site_name'),
            // 'field_desc'    => __('settings.add_site_name'),
        ],
        [
            'id'            => 'site_email',
            'type'          => 'text',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'value'         => setting('_general.site_email'),
            'class'         => '',
            'label_title'   => __('settings.site_email'),
            'placeholder'   => __('settings.enter_site_email'),
        ],
        [
            'id'            => 'date_format',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.date_format'),
            'options'       => [
                'F j, Y, g:i a' => date('F j, Y, g:i a') . ' (F j, Y, g:i a)',
                'F j, Y'        => date('F j, Y') . ' (F j, Y)',
                'Y-m-d'         => date('Y-m-d') . ' (Y-m-d)',
                'Y.m.d'         => date('Y.m.d') . ' (Y.m.d)',
                'd-m-Y'         => date('d-m-Y') . ' (d-m-Y)',
                'm/d/Y'         => date('m/d/Y') . ' (m/d/Y)',
                'd/m/Y'         => date('d/m/Y') . ' (d/m/Y)',
            ],
            'placeholder'   => __('settings.select_option'),
        ],
        [
            'id'            => 'address_format',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.address_format'),
            'options'       => [
                'city_country'          => __('settings.address_format1'),
                'state_country'         => __('settings.address_format2'),
                'city_state_country'    => __('settings.address_format3'),
            ],
            'placeholder'   => __('settings.select_option'),
        ],
        [
            'id'            => 'per_page_record',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.per_page_record'),
            'options'       => $per_page_rec,
            'placeholder'   => __('settings.select_option'),
        ],

        [
            'id'            => 'thousand_separator',
            'type'          => 'text',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'value'         => ',',
            'class'         => '',
            'label_title'   => __('settings.thousand_separator'),
            'placeholder'   => __('settings.enter_thousand_separator'),
        ],
        [
            'id'            => 'decimal_separator',
            'type'          => 'text',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'value'         => '.',
            'class'         => '',
            'label_title'   => __('settings.decimal_separator'),
            'placeholder'   => __('settings.enter_decimal_separator'),
        ],
        [
            'id'            => 'number_of_decimals',
            'type'          => 'number',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'value'         => '2',
            'class'         => '',
            'label_title'   => __('settings.number_of_decimals'),
            'placeholder'   => __('settings.enter_decimal_separator'),
        ],
        [
            'id'            => 'timezone',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.default_timezone'),
            'options'       => $timezones,
            'placeholder'   => __('settings.select_option'),
            'default'       => env('APP_TIMEZONE', 'UTC')
        ],
        [
            'id'            => 'table_responsive',
            'type'          => 'select',
            'tab_id'        => 'general_tab',
            'tab_title'     => __('settings.general'),
            'class'         => '',
            'label_title'   => __('settings.table_responsive'),
            'options'       => [
                'yes'   => __('settings.table_responsive'),
                'no'  => __('settings.horizontal_scroll'),
            ],
            'default'       => 'no',
            'placeholder'   => __('settings.select_option'),
        ],
        [
            'id'            => 'allowed_file_extensions',
            'type'          => 'text',
            'tab_id'        => 'upload_settings',
            'tab_title'     => __('settings.upload_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.allowed_file_extensions'),
            'placeholder'   => __('settings.enter_allowed_file_extensions'),
            // 'field_desc'    => __('settings.add_allowed_file_extensions'),
        ],
        [
            'id'            => 'max_file_size',
            'type'          => 'text',
            'tab_id'        => 'upload_settings',
            'tab_title'     => __('settings.upload_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.max_file_size'),
            'placeholder'   => __('settings.enter_max_file_size'),
            // 'field_desc'    => __('settings.add_max_file_size'),
        ],
        [
            'id'            => 'allowed_video_extensions',
            'type'          => 'text',
            'tab_id'        => 'upload_settings',
            'tab_title'     => 'Upload settings',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.allowed_video_extensions'),
            'placeholder'   => __('settings.enter_allowed_video_extensions'),
            // 'field_desc'    => __('settings.add_allowed_video_extensions'),
        ],
        [
            'id'            => 'max_video_size',
            'type'          => 'text',
            'tab_id'        => 'upload_settings',
            'tab_title'     => __('settings.upload_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.max_video_size'),
            'placeholder'   => __('settings.enter_max_video_size'),
            // 'field_desc'    => __('settings.add_max_video_size'),
        ],
        [
            'id'            => 'allowed_image_extensions',
            'type'          => 'text',
            'tab_id'        => 'upload_settings',
            'tab_title'     => __('settings.upload_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.allowed_image_extensions'),
            'placeholder'   => __('settings.enter_allowed_image_extensions'),
            // 'field_desc'    => __('settings.add_allowed_image_extensions'),
        ],
        [
            'id'            => 'max_image_size',
            'type'          => 'text',
            'tab_id'        => 'upload_settings',
            'tab_title'     => __('settings.upload_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.max_image_size'),
            'placeholder'   => __('settings.enter_max_image_size'),
            // 'field_desc'    => __('settings.add_max_image_size'),
        ],

        [
            'id'            => 'logo_white',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.site_logo_white'),
            'field_desc'    => __('settings.add_site_logo_white'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'logo_default',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.site_logo_default'),
            'field_desc'    => __('settings.add_site_logo_default'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'favicon',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.site_favicon'),
            'field_desc'    => __('settings.add_site_favicon'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'default_avatar_for_user',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.default_avatar_for_user'),
            // 'field_desc'    => __('settings.add_default_avatar_for_user'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'auth_pages_video',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.auth_pages_video'),
            'field_desc'    => __('settings.add_auth_pages_video'),
            'max_size'   => $video_size,                  // size in MB
            'ext'    => [
                'mp4',
                'avi',
            ],
        ],
        [
            'id'            => 'auth_pages_image_1',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.auth_pages_image_1'),
            'field_desc'    => __('settings.auth_pages_image_1'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'auth_pages_image_2',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.auth_pages_image_2'),
            'field_desc'    => __('settings.auth_pages_image_2'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'notification_image',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.notification_image'),
            'field_desc'    => __('settings.notification_image_description'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ],
        ],
        [
            'id'            => 'ios_app_logo',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.ios_app_logo'),
            'field_desc'    => __('settings.add_ios_app_logo'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'android_app_logo',
            'type'          => 'file',
            'tab_id'        => 'media',
            'tab_title'     => __('settings.media'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.android_app_logo'),
            'field_desc'    => __('settings.add_android_app_logo'),
            'max_size'   => $image_size,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],

        [
            'id'            => 'fb_link',
            'type'          => 'text',
            'tab_id'        => 'social_links',
            'tab_title'     => __('settings.social_links'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.facebook'),
            'placeholder'   => __('settings.enter_facebook_link'),
            // 'field_desc'    => __('settings.add_facebook_link'),
        ],
        [
            'id'            => 'insta_link',
            'type'          => 'text',
            'tab_id'        => 'social_links',
            'tab_title'     =>  __('settings.social_links'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.instagaram'),
            'placeholder'   => __('settings.enter_instagaram_link'),
            // 'field_desc'    => __('settings.add_instagaram_link'),
        ],
        [
            'id'            => 'linkedin_link',
            'type'          => 'text',
            'tab_id'        => 'social_links',
            'tab_title'     => __('settings.social_links'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.linkedin'),
            'placeholder'   => __('settings.enter_linkedin_link'),
            // 'field_desc'    => __('settings.add_linkedin_link'),
        ],
        [
            'id'            => 'yt_link',
            'type'          => 'text',
            'tab_id'        => 'social_links',
            'tab_title'     => __('settings.social_links'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.youtube'),
            'placeholder'   => __('settings.enter_youtube_link'),
            // 'field_desc'    => __('settings.add_youtube_link'),
        ],
        [
            'id'            => 'tiktok_link',
            'type'          => 'text',
            'tab_id'        => 'social_links',
            'tab_title'     => __('settings.social_links'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.tiktok'),
            'placeholder'   => __('settings.enter_tiktok_link'),
            // 'field_desc'    => __('settings.add_tiktok_link'),
        ],
        [
            'id'            => 'invoice_logo',
            'type'          => 'file',
            'tab_id'        => 'pdf_settings',
            'tab_title'     => __('settings.pdf_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.invoice_logo'),
            'field_desc'    => __('settings.add_invoice_logo'),
            'max_size'   => $image_size,
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'company_name',
            'type'          => 'text',
            'tab_id'        => 'pdf_settings',
            'tab_title'     => __('settings.pdf_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.company_name'),
            'placeholder'   => __('settings.enter_company_name'),
        ],
        [
            'id'            => 'company_email',
            'type'          => 'text',
            'tab_id'        => 'pdf_settings',
            'tab_title'     => __('settings.pdf_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.company_email'),
            'placeholder'   => __('settings.enter_company_email'),
        ],
        [
            'id'            => 'company_address',
            'type'          => 'text',
            'tab_id'        => 'pdf_settings',
            'tab_title'     => __('settings.pdf_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.company_address'),
            'placeholder'   => __('settings.enter_company_address'),
        ],



        // [
        //     'id'            => 'footer_paragraph',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.footer_paragraph'),
        //     'placeholder'   => __('settings.enter_footer_paragraph'),
        //     // 'field_desc'    => __('settings.add_footer_paragraph'),
        // ],
        // [
        //     'id'            => 'footer_contact',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.footer_contact'),
        //     'placeholder'   => __('settings.enter_footer_contact'),
        //     // 'field_desc'    => __('settings.add_footer_paragraph'),
        // ],
        // [
        //     'id'            => 'footer_email',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.footer_email'),
        //     'placeholder'   => __('settings.enter_footer_email'),
        //     // 'field_desc'    => __('settings.add_footer_paragraph'),
        // ],
        // [
        //     'id'            => 'footer_address',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.footer_address'),
        //     'placeholder'   => __('settings.footer_address'),
        //     // 'field_desc'    => __('settings.add_footer_paragraph'),
        // ],
        // [
        //     'id'            => 'footer_button_text',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.footer_button_text'),
        //     'placeholder'   => __('settings.enter_footer_button_text'),
        //     // 'field_desc'    => __('settings.add_footer_button_text'),
        // ],
        // [
        //     'id'            => 'footer_button_url',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.footer_button_url'),
        //     'placeholder'   => __('settings.enter_footer_button_url'),
        //     // 'field_desc'    => __('settings.add_footer_button_url'),
        // ],
        // [
        //     'id'            => 'quick_links_heading',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.quick_links_heading'),
        //     'placeholder'   => __('settings.enter_quick_links_heading'),
        //     // 'field_desc'    => __('Add quick links heading'),
        // ],
        // [
        //     'id'            => 'tutors_by_country_heading',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.tutors_by_country_heading'),
        //     'placeholder'   => __('settings.enter_tutors_by_country_heading'),
        //     // 'field_desc'    => __('Add tutors by country heading'),
        // ],
        // [
        //     'id'            => 'our_services_heading',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.our_services_heading'),
        //     'placeholder'   => __('settings.enter_our_services_heading'),
        //     // 'field_desc'    => __('Add tutors by country heading'),
        // ],
        // [
        //     'id'            => 'one_on_one_sessions_heading',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.one_on_one_sessions_heading'),
        //     'placeholder'   => __('settings.enter_one_on_one_sessions_heading'),
        //     // 'field_desc'    => __('Add tutors by country heading'),
        // ],
        // [
        //     'id'            => 'group_sessions_heading',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.group_sessions_heading'),
        //     'placeholder'   => __('settings.enter_group_sessions_heading'),
        //     // 'field_desc'    => __('Add tutors by country heading'),
        // ],
        // [
        //     'id'            => 'app_section_heading',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.app_section_heading'),
        //     'placeholder'   => __('settings.enter_app_section_heading'),
        //     // 'field_desc'    => __('settings.add_app_section_heading'),
        // ],
        // [
        //     'id'            => 'app_section_description',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.app_section_heading'),
        //     'placeholder'   => __('settings.enter_app_section_heading'),
        //     // 'field_desc'    => __('settings.add_app_section_heading'),
        // ],
        // [
        //     'id'            => 'app_android_link',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.android_app_link'),
        //     'placeholder'   => __('settings.android_app_placeholder'),
        // ],
        // [
        //     'id'            => 'app_ios_link',
        //     'type'          => 'text',
        //     'tab_id'        => 'front_page_settings',
        //     'tab_title'     => __('settings.front_page_settings'),
        //     'value'         => '',
        //     'class'         => '',
        //     'label_title'   => __('settings.ios_app_link'),
        //     'placeholder'   => __('settings.ios_app_placeholder'),
        // ],
    ]
];

if (isActiveModule('Courses')) {
    $settings['fields'][] = [
        'id'            => 'watermark_logo',
        'type'          => 'file',
        'tab_id'        => 'media',
        'tab_title'     => __('settings.video_watermark'),
        'value'         => '',
        'class'         => '',
        'label_title'   => __('settings.video_watermark'),
        'field_desc'    => __('settings.add_video_watermark'),
        'max_size'   => $image_size,                  // size in MB
        'ext'    => [
            'jpg',
            'png',
        ],
    ];
}

return $settings;
