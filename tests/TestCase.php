<?php

namespace Sztyup\Impostor\Tests;

use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as Base;
use Sztyup\Impostor\ImpersonationManager;
use Sztyup\Impostor\ImpostorServiceProvider;

class TestCase extends Base
{
    protected function setUp()
    {
        parent::setUp();

        /** @var Router $router */
        $router = $this->app->make('router');

        $router->get('/impersonate/{user}', function ($user, ImpersonationManager $manager) {
            $manager->impersonate($user);

            return response('success');
        });
    }

    protected function getPackageProviders($application)
    {
        return [
            ImpostorServiceProvider::class
        ];
    }
}
