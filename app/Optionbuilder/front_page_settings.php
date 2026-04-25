<?php

use Illuminate\Support\Facades\DB;

$all_site_pages = [];
$image_size     = (int) (setting('_general.max_image_size') ?? '5');
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
$all_site_pages['find-tutors'] = 'Find Tutors';
$all_site_pages['blogs'] = 'Blogs';
if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses')){
    $all_site_pages['courses.search-courses'] = 'Search Courses';
}

return [
    'section' => [
        'id'     => '_front_page_settings',
        'label'  => __('settings.front_page_settings'),
        'tabs'   => true,
        'icon'   => '',
    ],
    'fields' => [
        // general settings
        [
            'id'                => 'header_variation_for_pages',
            'type'              => 'repeater',
            'tab_id'            => 'general',
            'tab_title'         => __('settings.general'),
            'label_title'       => __('settings.header_variation_for_pages'),
            'repeater_title'    => __('settings.header_variation_for_pages'),
            'multi'             => true,
            'fields'            => [
                [
                    'id'            => 'page_id',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('settings.select_page'),
                    'options'       => $all_site_pages,
                    'placeholder'   => __('settings.select_option'),
                ],
                [
                    'id'            => 'header_variation',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('settings.header_variation'),
                    'options'       => [
                        'am-header_two'     => 'Header V1',
                        'am-header_three'   => 'Header V2',
                        'am-header_five'    => 'Header V3',
                        'am-header_four'    => 'Header V4',
                        'am-header_six'     => 'Header V5',
                        'am-header_seven'   => 'Header V6',
                        'am-header_eight'   => 'Header V7',
                        'am-header_nine'    => 'Header V8',
                    ],
                    'default'       => 'am-header_two',
                    'placeholder'   => __('settings.select_option'),
                ],
            ]
        ],
        [
            'id'                => 'footer_variation_for_pages',
            'type'              => 'repeater',
            'tab_id'            => 'general',
            'tab_title'         => __('settings.general'),
            'label_title'       => __('settings.footer_variation_for_pages'),
            'repeater_title'    => __('settings.footer_variation_for_pages'),
            'multi'             => true,
            'fields'            => [
                [
                    'id'            => 'page_id',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('settings.select_page'),
                    'options'       => $all_site_pages,
                    'placeholder'   => __('settings.select_option'),
                ],
                [
                    'id'            => 'footer_variation',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('settings.footer_variation'),
                    'options'       => [
                        'am-footer'         => 'Footer V1',
                        'am-footer_two'     => 'Footer V2',
                        'am-footer_three'   => 'Footer V3',
                    ],
                    'default'       => 'am-footer',
                    'placeholder'   => __('settings.select_option'),
                ],
            ]
        ],
        // end general settings

        // main footer settings
        [
            'id'            => 'footer_paragraph',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_paragraph'),
            'placeholder'   => __('settings.enter_footer_paragraph'),
        ],
        [
            'id'            => 'footer_contact',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_contact'),
            'placeholder'   => __('settings.enter_footer_contact'),
        ],
        [
            'id'            => 'footer_email',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_email'),
            'placeholder'   => __('settings.enter_footer_email'),
        ],
        [
            'id'            => 'footer_address',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_address'),
            'placeholder'   => __('settings.footer_address'),
        ],
        [
            'id'            => 'footer_button_text',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_button_text'),
            'placeholder'   => __('settings.enter_footer_button_text'),
        ],
        [
            'id'            => 'footer_button_url',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_button_url'),
            'placeholder'   => __('settings.enter_footer_button_url'),
        ],
        [
            'id'            => 'quick_links_heading',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.quick_links_heading'),
            'placeholder'   => __('settings.enter_quick_links_heading'),
        ],
        [
            'id'            => 'tutors_by_country_heading',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.tutors_by_country_heading'),
            'placeholder'   => __('settings.enter_tutors_by_country_heading'),
        ],
        [
            'id'            => 'our_services_heading',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.our_services_heading'),
            'placeholder'   => __('settings.enter_our_services_heading'),
        ],
        [
            'id'            => 'one_on_one_sessions_heading',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.one_on_one_sessions_heading'),
            'placeholder'   => __('settings.enter_one_on_one_sessions_heading'),
        ],
        [
            'id'            => 'group_sessions_heading',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.group_sessions_heading'),
            'placeholder'   => __('settings.enter_group_sessions_heading'),
        ],
        [
            'id'            => 'app_section_heading',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.app_section_heading'),
            'placeholder'   => __('settings.enter_app_section_heading'),
        ],
        [
            'id'            => 'app_section_description',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.app_section_heading'),
            'placeholder'   => __('settings.enter_app_section_heading'),
        ],
        [
            'id'            => 'app_android_link',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.android_app_link'),
            'placeholder'   => __('settings.android_app_placeholder'),
        ],
        [
            'id'            => 'app_ios_link',
            'type'          => 'text',
            'tab_id'        => 'main_footer_settings',
            'tab_title'     => __('settings.main_footer_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.ios_app_link'),
            'placeholder'   => __('settings.ios_app_placeholder'),
        ],
        // end main footer settings

        // footer settings v3
        [
            'id'            => 'footer_background_image',
            'type'          => 'file',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'class'         => '',
            'label_title'   => __('settings.footer_background_image'),
            'max_size'      => $image_size,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
                'jpeg',
                'webp',
            ], 
        ],
        [
            'id'            => 'footer_heading',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_heading'),
            'placeholder'   => __('settings.enter_footer_heading'),
        ],
        [
            'id'            => 'footer3_paragraph',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_paragraph'),
            'placeholder'   => __('settings.enter_footer_paragraph'),
        ],
        [
            'id'            => 'primary_button_text',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.primary_button_text'),
            'placeholder'   => __('settings.enter_primary_button_text'),
        ],
        [
            'id'            => 'primary_button_url',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.primary_button_url'),
            'placeholder'   => __('settings.enter_primary_button_url'),
        ],
        [
            'id'            => 'secondary_button_text',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.secondary_button_text'),
            'placeholder'   => __('settings.enter_secondary_button_text'),
        ],
        [
            'id'            => 'secondary_button_url',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.secondary_button_url'),
            'placeholder'   => __('settings.enter_secondary_button_url'),
        ],
        [
            'id'            => 'tutor_link_heading',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.tutor_link_heading'),
            'placeholder'   => __('settings.enter_tutor_link_heading'),
        ],
        [
            'id'            => 'join_lernen_link',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.lernen_link'),
            'placeholder'   => __('settings.enter_lernen_link'),
        ],
        [
            'id'            => 'join_lernen_link_url',
            'type'          => 'text',
            'tab_id'        => 'footer_settings_v3',
            'tab_title'     => __('settings.footer_settings_v3'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.lernen_link_url'),
            'placeholder'   => __('settings.enter_lernen_link_url'),
        ],
        // end footer settings v3

        // blogs settings
        [
            'id'            => 'blog_title',
            'type'          => 'text',
            'tab_id'        => 'blogs_settings',
            'tab_title'     => __('settings.blog_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.blog_title'),
            'placeholder'   => __('settings.enter_blog_title'),
        ],
        [
            'id'            => 'blog_pre_heading',
            'type'          => 'text',
            'tab_id'        => 'blogs_settings',
            'tab_title'     => __('settings.blog_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.blog_pre_heading'),
            'placeholder'   => __('settings.enter_blog_pre_heading'),
        ],
        [
            'id'            => 'blog_heading',
            'type'          => 'text',
            'tab_id'        => 'blogs_settings',
            'tab_title'     => __('settings.blog_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.blog_heading'),
            'placeholder'   => __('settings.enter_blog_heading'),
        ],
        [
            'id'            => 'blog_description',
            'type'          => 'text',
            'tab_id'        => 'blogs_settings',
            'tab_title'     => __('settings.blog_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.blog_description'),
            'placeholder'   => __('settings.enter_blog_description'),
        ],
        [
            'id'            => 'search_button_text',
            'type'          => 'text',
            'tab_id'        => 'blogs_settings',
            'tab_title'     => __('settings.blog_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.search_button_text'),
            'placeholder'   => __('settings.enter_search_button_text'),
        ],
        [
            'id'            => 'search_placeholder',
            'type'          => 'text',
            'tab_id'        => 'blogs_settings',
            'tab_title'     => __('settings.blog_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.search_placeholder'),
            'placeholder'   => __('settings.enter_search_placeholder'),
        ],
        [
            'id'            => 'all_blogs_heading',
            'type'          => 'text',
            'tab_id'        => 'blogs_settings',
            'tab_title'     => __('settings.blog_settings'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.all_blogs_heading'),
            'placeholder'   => __('settings.enter_all_blogs_heading'),
        ],
        [
            'id'            => 'per_page',
            'type'          => 'text',
            'tab_id'        => 'blogs_settings',
            'tab_title'     => __('settings.per_page'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.per_page'),
            'placeholder'   => __('settings.enter_per_page'),
        ],
        // end blogs settings

        // SEO settings
        [
            'id'                => 'seo_settings',
            'type'              => 'repeater',
            'tab_id'            => 'seo_setting',
            'tab_title'         => __('settings.seo_settings'),
            'label_title'       => __('settings.seo_settings_for_page'),
            'repeater_title'    => __('settings.seo_pages_setting'),
            'multi'             => true,
            'fields'            => [
                [
                    'id'            => 'page_id',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('settings.select_page'),
                    'options'       => $all_site_pages,
                    'placeholder'   => __('settings.select_option'),
                ],
                [
                    'id'            => 'seo_title',
                    'type'          => 'text',
                    'class'         => '',
                    'value'         => '',
                    'label_title'   => __('settings.seo_title'),
                    'placeholder'   => __('settings.enter_seo_title'),
                ],
                [
                    'id'            => 'seo_description',
                    'type'          => 'textarea',
                    'class'         => '',
                    'value'         => '',
                    'label_title'   => __('settings.seo_description'),
                    'placeholder'   => __('settings.enter_seo_description'),
                ],
                [
                    'id'            => 'seo_keywords',
                    'type'          => 'textarea',
                    'class'         => '',
                    'value'         => '',
                    'label_title'   => __('settings.seo_keywords'),
                    'placeholder'   => __('settings.enter_seo_keywords'),
                ],
            ]
        ],
        // end SEO settings
    ]
];
