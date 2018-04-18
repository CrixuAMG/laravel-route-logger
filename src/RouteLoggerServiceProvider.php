<?php

namespace CrixuAMG\RouteLogger;

use Illuminate\Support\ServiceProvider;

/**
 * Class RouteLoggerServiceProvider
 *
 * @package CrixuAMG
 */
class RouteLoggerServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        // Allow the user to get the config file
        $this->registerConfiguration();

        // Allow the user to get the migrations
        $this->registerMigrations();
    }

    /**
     * Register the config file
     */
    private function registerConfiguration()
    {
        $this->publishes([
            __DIR__ . '/config/route-logger.php' => config_path('route-logger.php'),
        ]);
    }

    /**
     * Register the migrations
     */
    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
