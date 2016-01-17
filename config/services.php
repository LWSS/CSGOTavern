<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'hipchat' => [
        'token' => '3682e63900f1af7470bf5550989a49',
        'name'  => 'Tavern Website', // HipChat Sender Name
        'room'  => [
            'name'  => 'CSGO Tavern',
            'id'    => 2069258,
        ],
    ],

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        // 'model'  => App\User::class,
        'key'    => env('STRIPE_PUBLISHABLE_KEY', ''),
        'secret' => env('STRIPE_SECRET_KEY', ''),
    ],

];
