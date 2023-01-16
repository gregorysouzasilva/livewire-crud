<?php

namespace Gregorysouzasilva\LivewireCrud;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LivewireCrudServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'gregorysouzasilva');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'crud');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        Blade::componentNamespace('gregorysouzasilva\\views\\components', 'crud');


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
        $this->mergeConfigFrom(__DIR__.'/../config/livewire-crud.php', 'livewire-crud');

        // Register the service the package provides.
        $this->app->singleton('livewire-crud', function ($app) {
            return new LivewireCrud;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['livewire-crud'];
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
            __DIR__.'/../config/livewire-crud.php' => config_path('livewire-crud.php'),
        ], 'livewire-crud.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/gregorysouzasilva'),
        ], 'livewire-crud.views');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/gregorysouzasilva'),
        ], 'livewire-crud.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/gregorysouzasilva'),
        ], 'livewire-crud.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
