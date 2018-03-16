<?php

namespace Sztyup\Impostor\Tests;

use Orchestra\Testbench\TestCase as Base;
use Sztyup\Impostor\ImpostorServiceProvider;

class TestCase extends Base
{
    protected function getPackageProviders($application)
    {
        return [
            ImpostorServiceProvider::class
        ];
    }
}
