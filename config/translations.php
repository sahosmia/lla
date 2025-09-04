<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel Translations Custom Domain
    |--------------------------------------------------------------------------
    | You may change the domain where Laravel Translations should be active.
    | If the domain is empty, all domains will be valid.
    |
    */
    'layout' => 'layouts.admin-app',

    /*
    |--------------------------------------------------------------------------
    | Laravel Translations Path
    |--------------------------------------------------------------------------
    |
    | The default is `translations` but you can change it to whatever works best and
    | doesn't conflict with the routing in your application.
    |
    */
    'path' => 'admin/translations',

    /*
    |--------------------------------------------------------------------------
    | Laravel Translations route middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every Laravel Translations route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => [
        'web','auth','role:admin|sub_admin'
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Connection
    |--------------------------------------------------------------------------
    |
    | The database connection that should be used to store the imported
    | translations You may specify the connection as a string
    | which is the name of the connection in the database.php file
    |
    */
    'database_connection' => null,

    'include_file_in_key' => false,

    /*
    |--------------------------------------------------------------------------
    | Source Language
    |--------------------------------------------------------------------------
    |
    | This is the language that will be used as the source language for
    | the translations. This language will be used to import the
    | translations from the files.
    |
    */
    'source_language' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Exclude Files
    |--------------------------------------------------------------------------
    |
    | The following files will be ignored during the import process.
    | and those files will be ignored in every language.
    |
    */
    'exclude_files' => [
        //'validation.php', // Exclude default validation for example.
    ],
];
