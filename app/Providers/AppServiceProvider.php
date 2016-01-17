<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Log;
use Monolog\Handler\FirePHPHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['sentinel.users']->setModel( 'App\Models\TavernUser' );
        // Register the attributes namespace
        $this->app['platform.attributes.manager']->registerNamespace( $this->app['App\Models\TavernUser'] );
        if ( config( 'app.debug' ) ) {
            // Get an instance of Monolog
            $monolog = Log::getMonolog();
            // Choose FirePHP as the log handler
            $monolog->pushHandler( new FirePHPHandler() );
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( 'Platform\Users\Models\User', 'App\Models\TavernUser' );
    }
}
