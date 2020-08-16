<?php

namespace Infinitypaul\LaravelUptime\Commands;

use Illuminate\Console\Command;
use Infinitypaul\LaravelUptime\Endpoint;

class RemoveEndPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'endpoint:remove {id :  The Endpoint ID To Remove} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Endpoint Command';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $endpoint = Endpoint::find($id = $this->argument('id'));
        if (! $endpoint) {
            $this->error("Endpoint With ID {$id} Doesn't Exist ");

            return;
        }

        $endpoint->delete();

        $this->info("Endpoint With ID {$id} Has Been Deleted ");
    }
}
