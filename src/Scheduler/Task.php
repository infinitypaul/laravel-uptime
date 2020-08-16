<?php

namespace Infinitypaul\LaravelUptime\Scheduler;

use Carbon\Carbon;
use Cron\CronExpression;

abstract class Task
{
    use Frequencies;

    abstract public function handle();

    public function isDueToRun()
    {
        return CronExpression::factory($this->expression)
            ->isDue(Carbon::now());
    }
}
