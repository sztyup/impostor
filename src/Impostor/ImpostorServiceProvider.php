<?php

namespace Sztyup\Impostor;

use Illuminate\Support\ServiceProvider;

class ImpostorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ImpersonationManager::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/impostor.php',
            'nexus'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('impostor.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../view', 'impostor');
    }
}
