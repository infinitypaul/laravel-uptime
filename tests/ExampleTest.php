<?php

namespace Infinitypaul\LaravelUptime\Tests;

use Orchestra\Testbench\TestCase;
use Infinitypaul\LaravelUptime\LaravelUptimeServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelUptimeServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
