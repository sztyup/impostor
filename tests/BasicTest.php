<?php

namespace Sztyup\Impostor\Tests;

class BasicTest extends TestCase
{
    public function testImpersonation()
    {
        $this->get('/impersonate/2')
            ->assertSuccessful()
            ->assertSee('success')
        ;
    }
}