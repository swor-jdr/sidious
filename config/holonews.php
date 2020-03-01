<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Wink Database Connection
    |--------------------------------------------------------------------------
    |
    | This is the database connection you want Wink to use while storing &
    | reading your content. By default Wink assumes you've prepared a
    | new connection called "wink". However, you can change that
    | to anything you want.
    |
    */

    'database_connection' => env('HOLONEWS_DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Wink Uploads Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Wink will use to put file uploads, you can use
    | any of the disks defined in your config/filesystems.php file. You may
    | also configure the path where the files should be stored.
    |
    */

    'storage_disk' => env('HOLONEWS_STORAGE_DISK', 'local'),

    'storage_path' => env('HOLONEWS_STORAGE_PATH', 'public/holonews/images'),

    /*
    |--------------------------------------------------------------------------
    | Wink Path
    |--------------------------------------------------------------------------
    |
    | This is the URI prefix where Wink will be accessible from. Feel free to
    | change this path to anything you like.
    |
    */

    'path' => env('HOLONEWS_PATH', 'holonews'),

    /*
    |--------------------------------------------------------------------------
    | Wink Middleware Group
    |--------------------------------------------------------------------------
    |
    | This is the middleware group that wink use.
    | By default is the web group a correct one.
    | It need at least the next middlewares
    | - StartSession
    | - ShareErrorsFromSession
    |
    */
    'middleware_group' => env('HOLONEWS_MIDDLEWARE_GROUP', 'web'),
];
