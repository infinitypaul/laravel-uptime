<?php


namespace Infinitypaul\LaravelUptime\Commands\Traits;


trait CanForce
{
    protected function isForced(){
        return $this->option('force') !== false;
    }
}
