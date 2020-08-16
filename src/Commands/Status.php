<?php

namespace Infinitypaul\LaravelUptime\Commands;

use Illuminate\Console\Command;
use Infinitypaul\LaravelUptime\Commands\Traits\CanForce;
use Infinitypaul\LaravelUptime\Endpoint;

class Status extends Command
{
    use CanForce;

    protected $client;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uptime:status {--F|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display The Status Of All Endpoint In A Table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->isForced()) {
            $this->call('uptime:run', ['--force'=> true]);
        }
        $headers = ['ID', 'URI', 'Frequency', 'Last Checked', 'Human Date', 'Status', 'Response Code'];

        Endpoint::with('statuses')->chunk(100, function ($endpoints) use ($headers) {
            $this->table($headers, $endpoints->map(function ($endpoint) {
                return array_merge(
                    $endpoint->only(['id', 'uri', 'frequency']),
                    $endpoint->status ? $this->getEndpointStatus($endpoint) : []
                );
            })->toArray()
            );
        });


    }

    protected function getEndpointStatus(Endpoint $endpoint)
    {
        return [
            'created_at' => $endpoint->status->created_at,
            'human_date' => $endpoint->status->created_at->diffForHumans(),
            'status' => $this->formatStatus($endpoint->status),
            'status_code' => $endpoint->status->status_code,
        ];
    }

    protected function formatStatus($status)
    {
        if ($status->isDown()) {
            return '<error>Down</error>';
        }

        return '<bg=green;fg=black>Up</>';
    }
}
