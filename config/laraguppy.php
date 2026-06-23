<?php

return [

    /*
     |
     | Settings for LaraGuppy package.
     |
     */

    'db_prefix'                      => 'lg__',                  // prefix for database tables
    'url_prefix'                     => '',                      // like admin if you are using it in admin panel
    'route_middleware'               => ['auth'],                // route middlewares like auth, role etc
    'api_authentication_middleware'  => ['auth:sanctum'],        // auth:api for passport                              
    'layout'                         => 'layouts.app',                      // Leave emtpy to load default layout for laraguppy massenger
    'content_yeild'                  => 'content',               // section variable name that yields from above layout
    'style_stack'                    => 'styles',                // push style variable for style css
    'script_stack'                   => 'scripts',               // push scripts variable for custom js and scripts files  

    /*
    |
    | if user inforamtion from other than User model please specify relation defined in user_class
    |
    */
    'userinfo_relation'              => 'profile',

    /*
    |
    | Enable to send chat invitation to start the chat with each other. 
    |
    */
    'enable_chat_invitation'              => false,

    /*
    |
    | it can be a column/attribute defined in userinfo_relation class, it can be first name or complete  name of user.  
    |
    */

    'user_first_name_column'        => 'first_name',
    /*
    |
    | it can be a column/attribute defined in userinfo_relation class, leave empty if don't have last name
    |
    */

    'user_last_name_column'         => 'last_name',
    /*
    |
    | it can be a column/attribute defined in user_class, leave empty if defualt users
    |
    */

    'user_email_column'             => '',
    /*
    |
    | it can be a column/attribute defined in user_class, please fill only when applicable
    |
    */

    'user_image_column'              => 'image',
    /*
    |
    | it can be a column/attribute defined in user_class, please fill only when applicable
    |
    */

    'user_phone_column'              => '',
    /*
    |
    | pagination per_page
    |
    */

    'per_page_records'               => '20',

    /*
    |
    | Enable tabs to show on laraguppy chat
    |
    */
    'enable_tabs'                   => ['private_chat', 'friend_list', 'contact_list'],

    /*
    |
    | Default active tab
    |
    */
    'default_active_tab'            => 'private_chat',
    /*
    |
    | Enable option to report against a user 
    |
    */
    'report_user'                   => true,
    /*
    |
    | Report reasons options
    |
    */
    'reporting_reasons'             => ['Inappropriate Content', 'Spam', 'Privacy violates', 'Others' ],
    
    /*
    |
    | User default avater image url
    |
    */
    'default_avatar_url'            => '',
    /*
    |
    | allow delete unseen message option
    |
    */

    'delete_message'                => true,

    /*
    |
    | allow clear chat option
    |
    */
    'clear_chat'                    => true,
    
    /*
    |
    | Message time format 12hrs or 24hrs
    |
    */
    'time_format'                   => '12hrs',

    /*
    |
    | Enable location sharing option 
    |
    */
    'location_sharing'              => true,
    
    /*
    |
    | Enable emoji sharing option 
    |
    */
    'emoji_sharing'                 => true,

    /*
    |
    | Enable voice note sharing option 
    |
    */
    'voice_sharing'                 => true,

    /*
    |
    | Upload image size in "KB"
    |
    */
    'image_size'                    => 5000,

    /*
    |
    | Upload image file allowable extensions
    |
    */
    'image_ext'                     => ['.jpg','.jpeg','.gif','.png'],

    /*
    |
    | Upload audio file size in "KB"
    |
    */
    'audio_file_size'               => 10000,

    /*
    |
    | Upload audio file allowable extensions
    |
    */
    'audio_file_ext'               => ['.mp3','.wav'],

    /*
    |
    | Upload video file size in "KB"
    |
    */
    'video_file_size'               => 10000,
    
    /*
    |
    | Upload video file allowable extensions
    | allowable options are '.mp4', '.ogv', '.webm', '.wmv', '.avi', '.mov', '.flv', '.f4v', '.mpeg', '.3gp', '.mkv'
    */
    'video_file_ext'               => ['.mp4','.flv','.3gp'],  
    
    /*
    |
    | Upload document file size in "KB"
    |
    */
    'document_file_size'            => 10000,
    
    /*
    |
    | Upload video file allowable extensions
    | allowable options are '.pdf', '.doc', '.txt', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', '.zip', '.7zip', '.csv'
    */
    'document_file_ext'             => ['.pdf','.doc','.txt'],

    /*
    |
    | Add the audio file URL to play the notification bell when a message is received.
    |
    */
    'notification_bell_url'         => '',

    /*
    |
    | Add the URL link of redirect button.
    |
    */
    'redirect_url'                  => '',

    /*
    |
    | Added roles will be excluded from the contacts. Leave empty if you don't have spatie roles.
    |
    */
    'exclude_roles'                  => ['admin'],

    /*
    |
    | Enable/Disable Right to Left Content
    |
    */
    'enable_rtl'                     => 'no',
];
