<?php

namespace Bespoke\ImprovMX;

use Illuminate\Support\ServiceProvider;

class ImprovMXServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
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
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/improvmx.php', 'improvmx');

        // Register the service the package provides.
        $this->app->singleton('improvmx', function ($app) {
            return new ImprovMX;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['improvmx'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/improvmx.php' => config_path('improvmx.php'),
        ], 'improvmx.config');
    }
}
