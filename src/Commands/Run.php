<?php

namespace Infinitypaul\LaravelUptime\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Infinitypaul\LaravelUptime\Commands\Traits\CanForce;
use Infinitypaul\LaravelUptime\Endpoint;
use Infinitypaul\LaravelUptime\Scheduler\Kernel;
use Infinitypaul\LaravelUptime\Tasks\PingEndPoint;

class Run extends Command
{
    use CanForce;

    protected $client;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uptime:run {--F|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run The Whole Endpoint';

    /**
     * Create a new command instance.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $kernel = new Kernel();
        //$endpoints = Endpoint::get();

        Endpoint::orderBy('id')->chunk(100, function ($endpoints) use ($kernel) {;
            foreach ($endpoints as $endpoint) {
                $kernel->add(
                    new PingEndPoint($endpoint, $this->client)
                )->everyMinutes(
                    $this->isForced() ? 1 : $endpoint->frequency
                );
            }
            $kernel->run();
        });

    }
}
