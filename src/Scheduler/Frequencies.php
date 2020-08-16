<?php


namespace Infinitypaul\LaravelUptime\Scheduler;


trait Frequencies
{
    protected $expression = '* * * * *';

    public function everyMinutes($minutes=1){
        $this->expression = "*/{$minutes} * * * *";
    }
}
