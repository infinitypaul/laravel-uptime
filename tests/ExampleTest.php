<?php

namespace Infinitypaul\LaravelUptime\Tests;

use Infinitypaul\LaravelUptime\LaravelUptimeServiceProvider;
use Orchestra\Testbench\TestCase;

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
