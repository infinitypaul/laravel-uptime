<?php

namespace Infinitypaul\LaravelUptime\Commands;

use Illuminate\Console\Command;
use Infinitypaul\LaravelUptime\Endpoint;

class AddEndPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'endpoint:add {endpoint :  The Endpoint To Monitor} {--f|frequency=5 : The Frequency To Check This Endpoint, In Minutes} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add An Endpoint To Monitor';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $frequency = is_numeric($this->option('frequency')) ? $this->option('frequency') : 5;
        if (! filter_var($uri = $this->argument('endpoint'), FILTER_VALIDATE_URL)) {
            $this->error("Endpoint {$uri} is not a valid uri.");

            return;
        }

        Endpoint::create([
            'uri' =>$uri = $this->argument('endpoint'),
            'frequency' => $frequency,
        ]);

        $this->info("Endpoint {$uri} is now being monitored.");

        $this->call('uptime:status');
    }
}
