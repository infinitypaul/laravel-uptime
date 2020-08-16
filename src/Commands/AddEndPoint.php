<?php

namespace Infinitypaul\LaravelUptime\Commands;

use Illuminate\Console\Command;
use Infinitypaul\LaravelUptime\Endpoint;
use Infinitypaul\LaravelUptime\Tasks\PingEndPoint;

class AddEndPoint extends Command
{

    protected $uri;
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
        $this->validateEndpoint();

        $frequency = is_numeric($this->option('frequency')) ? $this->option('frequency') : 5;

        Endpoint::create([
            'uri' => $this->uri,
            'frequency' => $frequency,
        ]);

        $this->info("Endpoint {$this->uri} is now being monitored.");

        $this->call('uptime:status');
    }

    protected function validateEndpoint(){
        $this->checkSelf();

        if (! filter_var($this->uri, FILTER_VALIDATE_URL)) {
            $this->error("Endpoint {$this->uri} is not a valid uri.");
            die();
        }
    }

    protected function checkSelf(){
        if($this->argument('endpoint') === 'own') {
            $this->uri = config('app.url');
            return;
        }
            $this->uri = $this->argument('endpoint');
    }
}
