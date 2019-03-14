<?php

namespace R64\LaravelThinq;

use Illuminate\Support\ServiceProvider;

class LaravelThinqServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(ThinqChannel::class)
            ->needs(Thinq::class)
            ->give(function () {
                return new Thinq($this->app->make(ThinqConfig::class));
            });

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelthinq.php', 'thinq');

        $this->app->bind(ThinqConfig::class, function ($app) {
            return new ThinqConfig(config('thinq'));
        });

        // Register the service the package provides.
        $this->app->singleton('laravelthinq', function ($app) {
            return new Thinq($this->app->make(ThinqConfig::class));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelthinq'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelthinq.php' => config_path('thinq.php'),
        ], 'laravelthinq.config');


        // Registering package commands.
        // $this->commands([]);
    }
}
