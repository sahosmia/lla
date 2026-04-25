<?php

return [
    /*
     |
     | Settings for Upcertify package.
     |
     */

    'db_prefix'                     => 'uc__',                  // prefix for database tables
    'url_prefix'                    => '',             // like admin if you are using it in admin panel
    'route_middleware'              => ['auth'],                // route middlewares like auth, role etc                         
    'layout'                        => 'layouts.app',           // Leave emtpy to load default layout for upcertify layout
    'content_yeild'                 => 'content',               // section variable name that yields from above layout
    'style_stack'                   => 'styles',                // push style variable for style css
    'script_stack'                  => 'scripts',               // push scripts variable for custom js and scripts files
    'google_font_api'               => '',                      // Add the Google Fonts API to display all available Google fonts for changing the font of wildcards.
    'livewire_scripts'              => false,
    'livewire_styles'               => false,
    'logo_url'                      => '/modules/upcertify/images/logo.svg',
    'show_logo'                     => false,
    'show_sidebar_menu'             => false,
    'user_table_name'               => 'users',
    'user_model_name'               => 'App\Models\User',
    'add_jquery'                    => true,                            // true/false to add/remove jquery js from the package
    'wildcards'                     => [ 
        'tutor_name', 'student_name', 'gender', 'tutor_tagline', 'issued_by', 'platform_name','platform_email', 'meeting_platform', 'subject_name', 'subject_group_name', 
        'session_date', 'session_time', 'issue_date', 'student_email', 'tutor_email', 'session_fee',
        'course_title', 'course_subtitle', 'course_category', 'course_subcategory', 'course_description', 'course_type', 'course_level',  'course_language', 'free_course',
        'course_price', 'course_discount' ,
    ]
];
