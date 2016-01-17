<?php

/**
 * Part of the Sentinel Social package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Sentinel Social
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    |
    | Connections are simple. Each key is a unique slug for the connection. Use
    | anything, just make it unique. This is how you reference it in Sentinel
    | Social. Each slug requires a driver, which must match a valid inbuilt
    | driver or may match your own custom class name that inherits from a
    | valid base driver.
    |
    | Make sure each connection contains an "identifier" and a "secret". Thse
    | are also known as "key" and "secret", "app id" and "app secret"
    | depending on the service. We're using "identifier" and
    | "secret" for consistency.
    |
    | OAuth2 providers may contain an optional "scopes" array, which is a
    | list of scopes you're requesting from the user for that connection.
    |
    | You may use multiple connections with the same driver!
    |
    */

    'connections' => [

        'vionox' => [

            // The driver should match your implementation's name (including namespace)
            'driver'     => 'App\Drivers\VionoxAuth',

            'identifier' => '7VmDk5OdQPPOtOZNWBpdzbEAsuza7hXG5fZZ1jJd',
            'secret'     => 'UD7klmRtPs8Jkv5jpVi7ywgVB0TquEfsM2BNjvwF',

            // To override OAuth2 scopes (scopes don't exist on OAuth 1), specify
            // this parameter. Otherwise, the default scopes from your implementation
            // class will be used.
            'scopes'     => ['vionox.official'],
        ],

        'facebook' => [
            'driver'     => 'Facebook',
            'identifier' => '',
            'secret'     => '',
            'scopes'     => [
                'email',
            ],
        ],

        'github' => [
            'driver'     => 'GitHub',
            'identifier' => '',
            'secret'     => '',
            'scopes'     => [
                'user',
            ],
        ],

        'google' => [
            'driver'     => 'Google',
            'identifier' => '',
            'secret'     => '',
            'scopes'     => [
                'https://www.googleapis.com/auth/userinfo.profile',
                'https://www.googleapis.com/auth/userinfo.email',
            ],
        ],

        'instagram' => [
            'driver'     => 'Instagram',
            'identifier' => '',
            'secret'     => '',
            'scopes'     => [
                'basic',
            ],
        ],

        'linkedin' => [
            'driver'     => 'LinkedIn',
            'identifier' => '',
            'secret'     => '',
            'scopes'     => [
                'r_fullprofile',
                'r_emailaddress',
            ],
        ],

        'microsoft' => [
            'driver'     => 'Microsoft',
            'identifier' => '',
            'secret'     => '',
            'scopes'     => [
                'wl.basic',
                'wl.emails'
            ],
        ],

        'twitter' => [
            'driver'     => 'Twitter',
            'identifier' => '',
            'secret'     => '',
        ],

        'tumblr' => [
            'driver'     => 'Tumblr',
            'identifier' => '',
            'secret'     => '',
        ],

        'vkontakte' => [
            'driver'     => 'Vkontakte',
            'identifier' => '',
            'secret'     => '',
            'scopes'     => [],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Link Model
    |--------------------------------------------------------------------------
    |
    | When users are registered, a "link repository" will map the social
    | authentications with user instances. Feel free to use your own model
    | with our provider.
    |
    */

    'link' => 'Cartalyst\Sentinel\Addons\Social\Models\Link',

];
