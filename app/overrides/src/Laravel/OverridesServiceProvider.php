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

namespace Cartalyst\Platform\Laravel;

use Cartalyst\Platform\Redirector;
use Cartalyst\Platform\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class OverridesServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerRedirector();
        $this->registerUrlGenerator();
    }

    /**
     * Registers the Redirector.
     *
     * @return void
     */
    protected function registerRedirector()
    {
        $this->app->bindShared('redirect', function ($app) {
            $redirector = new Redirector($app['url']);

            // If the session is set on the application instance, we'll inject it into
            // the redirector instance. This allows the redirect responses to allow
            // for the quite convenient "with" methods that flash to the session.
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });
    }

    /**
     * Registers the UrlGenerator.
     *
     * @return void
     */
    protected function registerUrlGenerator()
    {
        $this->app->bindShared('url', function ($app) {
            $routes = $app['router']->getRoutes();

            $request = $app->rebinding('request', function ($app, $request) {
                $app['url']->setRequest($request);
            });

            $urlGenerator = new UrlGenerator($routes, $request);

            return $urlGenerator;
        });
    }
}
