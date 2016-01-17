<?php
/**
 * Part of the Filesystem package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Filesystem
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Maximum allowed size for uploaded files
    |--------------------------------------------------------------------------
    |
    | Define here the maximum size of an uploaded file in bytes.
    |
    | Default: 10 Mb.
    |
    */

    'max_filesize' => 10485760,

    /*
    |--------------------------------------------------------------------------
    | Allowed types of files
    |--------------------------------------------------------------------------
    |
    | Define here all the allowed mime types that are allowed for upload.
    |
    | Look at http://www.iana.org/assignments/media-types for a
    | complete list of standard MIME types
    |
    */

    'allowed_mimes' => [

        // Audio & Video
        'audio/ogg', 'video/mp4', 'video/ogg',

        // Application
        'application/zip', 'application/pdf',

        // Images
        'image/gif', 'image/jpeg', 'image/png',

        // Text
        'text/plain',

    ],

    /*
    |--------------------------------------------------------------------------
    | File dispersion
    |--------------------------------------------------------------------------
    |
    | This feature allows you to have a better and more organized file
    | structure that you dictate using placeholders.
    |
    | To disable this feature just set a boolean of "false" as the value.
    |
    | Reserved placeholders:
    |
    |   Information from uploaded files
    |       :extension -> jpg
    |       :mime      -> image/jpeg
    |
    | Supported placeholders by default:
    |
    |   Current Year
    |       :yyyy  ->  2013
    |       :yy    ->  13
    |
    |   Current Month
    |       :mmmm  ->  November
    |       :mmm   ->  Nov
    |       :mm    ->  11
    |
    |   Current Day
    |       :dddd  ->  Friday
    |       :ddd   ->  Fri
    |       :dd    ->  24
    |
    | Note: You need to add the forward slash (/) at the end.
    |
    | Example:
    |
    |   'dispersion' => ':yyyy/:mm/'
    |
    |   All your files will be stored, by default, on:
    |
    |       app/storage/filesystem/2014/01/foo.jpg
    |       app/storage/filesystem/2014/01/bar.png
    |       app/storage/filesystem/2014/01/test.pdf
    |
    */

    'dispersion' => ':yyyy/:mm/',

    /*
    |--------------------------------------------------------------------------
    | Placeholders
    |--------------------------------------------------------------------------
    |
    | Define here all the file dispersion placeholders.
    |
    */

    'placeholders' => [

        ':yyyy' => date('Y'),
        ':yy'   => date('y'),
        ':mmmm' => date('F'),
        ':mmm'  => date('M'),
        ':mm'   => date('m'),
        ':dddd' => date('l'),
        ':ddd'  => date('D'),
        ':dd'   => date('d'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Connection
    |--------------------------------------------------------------------------
    |
    | Define here the connection name that you want to use by default.
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    |
    | Below are all default connections for the various drivers you can use.
    |
    */

    'connections' => [

        // Local
        'local' => [

            'adapter' => 'local',
            'path'    => storage_path().'/files',

        ],

        // Zip
        'zip' => [

            'adapter' => 'zip',
            'path'    => storage_path().'/files/filesystem.zip',

        ],

        // Amazon S3
        'awss3' => [

            'adapter' => 'awss3',
            'key'     => null,
            'secret'  => null,
            'bucket'  => null,
            'prefix'  => null,
            'region'  => null,
            'options' => [

            ],

        ],

        // Dropbox
        'dropbox' => [

            'adapter'  => 'dropbox',
            'token'    => null,
            'app_name' => null,
            'prefix'   => null,

        ],

        // Rackspace
        'rackspace' => [

            'adapter'   => 'rackspace',
            'endpoint'  => null,
            'username'  => null,
            'password'  => null,
            'container' => null,
            'service'   => 'cloudFiles',
            'region'    => 'LON',

        ],

        // WebDAV
        'webdav' => [

            'adapter'  => 'webdav',
            'baseUri'  => 'http://example.com/dav/',
            'username' => null,
            'password' => null,

        ],

        // File Transfer Protocol
        'ftp' => [

            'adapter'  => 'ftp',
            'host'     => 'ftp.example.com',
            'port'     => 21,
            'username' => 'username',
            'password' => 'password',
            'root'     => '/path/to/root',
            'passive'  => true,
            'ssl'      => true,
            'timeout'  => 30,

        ],

        // SSH File Transfer Protocol
        'sftp' => [

            'adapter'    => 'sftp',
            'host'       => 'sftp.example.com',
            'port'       => 22,
            'username'   => 'username',
            'password'   => 'password',
            'root'       => '/path/to/root',
            'privateKey' => 'path/to/or/contents/of/privatekey',
            'timeout'    => 10,

        ],

    ],

];
