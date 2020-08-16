<?php

namespace Infinitypaul\LaravelUptime;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Infinitypaul\LaravelUptime\Skeleton\SkeletonClass
 */
class LaravelUptimeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-uptime';
    }
}
