<?php namespace App\Providers;
/**
 * Part of the CSGO-Trading-Site application.
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) VIONOX, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brandon Xversial <xversial@vionox.com>, 09 2015
 */

use Illuminate\Support\ServiceProvider;
class UserOverrideServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['sentinel.users']->setModel('App\Models\VionoxUser');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Platform\Users\Models\User', 'App\Models\VionoxUser');
    }
}