<?php

namespace Infinitypaul\LaravelUptime;

use Illuminate\Support\ServiceProvider;
use Infinitypaul\LaravelUptime\Commands\AddEndPoint;
use Infinitypaul\LaravelUptime\Commands\RemoveEndPoints;
use Infinitypaul\LaravelUptime\Commands\Run;

class LaravelUptimeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-uptime');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-uptime');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishMigration();
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('uptime.php'),
            ], 'config');



            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-uptime'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-uptime'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-uptime'),
            ], 'lang');*/

             //Registering package commands.
             $this->commands([
                 AddEndPoint::class,
                 Run::class,
                 \Infinitypaul\LaravelUptime\Commands\Status::class,
                 RemoveEndPoints::class
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'uptime');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-uptime', function () {
            return new LaravelUptime;
        });
    }

    /**
     * Publish Laravel Uptime migration.
     */
    protected function publishMigration()
    {
        if (! class_exists('UptimeSetupTables')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/../database/migrations/2016_05_18_000000_uptime_setup_tables.php' => database_path('migrations/'.$timestamp.'_uptime_setup_tables.php'),
            ], 'migrations');
        }
    }
}
