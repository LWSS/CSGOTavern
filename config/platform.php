<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Platform
 * @version    4.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

    /*
    |--------------------------------------------------------------------------
    | App
    |--------------------------------------------------------------------------
    |
    | Basic configuration for your Platform application.
    |
    */

    'app' => [

        /*
        |--------------------------------------------------------------------------
        | App Title
        |--------------------------------------------------------------------------
        |
        | Here you may specify the title of the site you are building, to be used
        | throughout your templates (as an example).
        |
        */

        'title' => 'Platform',

        /*
        |--------------------------------------------------------------------------
        | App Tagline
        |--------------------------------------------------------------------------
        |
        | Here you may specify the tagline of the site you are building, to be used
        | throughout your templates (as an example).
        |
        */

        'tagline' => 'An application base on Laravel',

        /*
        |--------------------------------------------------------------------------
        | App Email
        |--------------------------------------------------------------------------
        |
        | Here you may specify your website general email address, this can be
        | used on other extensions to send emails.
        |
        */

        'email' => null,

        /*
        |--------------------------------------------------------------------------
        | App Copyright
        |--------------------------------------------------------------------------
        |
        | Specify the copyright clause for your website
        |
        */

        'copyright' => '&copy; 2015 CSGOTavern',

        /*
        |--------------------------------------------------------------------------
        | App Help
        |--------------------------------------------------------------------------
        |
        | Enable or disable the help sections
        |
        */

        'help' => true,

    ],

    /*
    |--------------------------------------------------------------------------
    | Frontend
    |--------------------------------------------------------------------------
    |
    | Configuration the frontend of your Platform application.
    |
    */

    'frontend' => [

        /*
        |--------------------------------------------------------------------------
        | Menu
        |--------------------------------------------------------------------------
        |
        | Here you can list the order for which the menu children will appear
        | in the admin of your application. Feel free to add any menus for
        | any extensions your application ships with!
        |
        | If a menu children doesn't exist, it'll be skipped, the
        | order however, will be preserved.
        |
        */

        'menu' => [

            'main-documentation',
            'main-support',
            'main-license',

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    |
    | Configuration the administration of your Platform application.
    |
    */

    'admin' => [

        /*
        |--------------------------------------------------------------------------
        | Menu
        |--------------------------------------------------------------------------
        |
        | Here you can list the order for which the menu children will appear
        | in the admin of your application. Feel free to add any menus for
        | any extensions your application ships with!
        |
        | If a menu children doesn't exist, it'll be skipped, the
        | order however, will be preserved.
        |
        */

        'menu' => [

            'admin-pages',
            'admin-content',
            'admin-media',
            'admin-attributes',
            'admin-menus',
            'admin-access',
            'admin-operations',

        ],

    ],

];
