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
    }

    /**
     * Register the config file
     */
    private function registerConfiguration()
    {
        $this->publishes([
            __DIR__ . '/config/route-loggers.php' => config_path('route-loggers.php'),
        ]);
    }
}
