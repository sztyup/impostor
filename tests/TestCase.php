<?php

namespace Sztyup\Impostor\Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Debug\HtmlDumper;
use Orchestra\Testbench\TestCase as Base;
use Sztyup\Impostor\ImpersonationManager;
use Sztyup\Impostor\ImpostorServiceProvider;
use Sztyup\Impostor\Middleware\Impersonate;

class TestCase extends Base
{
    protected function setUp()
    {
        parent::setUp();

        /** @var Router $router */
        $router = $this->app->make('router');

        $router->get('/impersonate/{id}', function ($id, ImpersonationManager $manager) {
            $user = new User();
            $user->id = $id;

            $manager->impersonate($user);

            return response('<html><head><title>asd</title></head><body>success</body>');
        })->middleware(['web', Impersonate::class]);
    }

    protected function getPackageProviders($application)
    {
        return [
            ImpostorServiceProvider::class
        ];
    }
}
