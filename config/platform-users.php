<?php
/**
 * Part of the Platform Users extension.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Platform Users extension
 * @version    1.0.5
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Login Columns
    |--------------------------------------------------------------------------
    |
    | Define here all the columns that can be used to authenticate
    | the users against, if all or some of the columns are passed
    | through the form, it is considered a combo login.
    |
    */

    'login_columns' => [

        'email',
        'password',

    ],

    /*
    |--------------------------------------------------------------------------
    | Account Registration
    |--------------------------------------------------------------------------
    |
    | This determines whether new users are allowed to self register.
    |
    */

    'registration' => true,

    /*
    |--------------------------------------------------------------------------
    | Send Password on Registration
    |--------------------------------------------------------------------------
    |
    | This determines whether the user's initial password will be emailed to
    | the user as part of the registration email.
    |
    */

    'send_password' => false,

    /*
    |--------------------------------------------------------------------------
    | Account Activation
    |--------------------------------------------------------------------------
    |
    | This determines whether users have immediate access to their account or
    | if a confirmation email is required. You can also completely disable
    | this functionallity.
    |
    | Supported: "automatic", "email", "admin"
    |
    */

    'activation' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Default role
    |--------------------------------------------------------------------------
    |
    | Define here the slug of the default role that users will be
    | assigned to when they create an account.
    |
    */

    'default_role' => 'registered',

];
