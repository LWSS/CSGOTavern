<?php
/**
 * Part of the CSGO-Tavern application.
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) VIONOX, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brandon Xversial <xversial@vionox.com>, 11 2015
 */


namespace App\Providers;


use App\Libraries\HipChat;
use Illuminate\Support\ServiceProvider;

class HipChatServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    /*public function boot()
    {

    }*/

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton( 'hipchat', function ( $app ) {
            return new HipChat($app['config']->get('services.hipchat.token'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'hipchat',
        ];
    }

}