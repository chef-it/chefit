<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MathServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['Math'] = $this->app->share(function($app)
        {
            return new \App\Classes\Math;
        });
    }
}
