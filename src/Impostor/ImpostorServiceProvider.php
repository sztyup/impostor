<?php

namespace Sztyup\Impostor;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Sztyup\Impostor\Middleware\Impersonate;

class ImpostorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ImpersonationManager::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php',
            'impostor'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('impostor.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../views', 'impostor');
    }
}
