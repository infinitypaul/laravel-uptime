<?php

namespace Infinitypaul\LaravelUptime\Tasks;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Infinitypaul\LaravelUptime\Endpoint;
use Infinitypaul\LaravelUptime\Events\EndpointIsBackUp;
use Infinitypaul\LaravelUptime\Events\EndpointIsDown;
use Infinitypaul\LaravelUptime\Scheduler\Task;

class PingEndPoint extends Task
{
    protected $client;
    /**
     * @var \Infinitypaul\LaravelUptime\Endpoint
     */
    protected $endpoint;

    public function __construct(Endpoint $endpoint, Client $client)
    {
        $this->client = $client;
        $this->endpoint = $endpoint;
    }

    public function handle()
    {
        try {
            $response = $this->client->request('GET', $this->endpoint->uri);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $this->endpoint->statuses()->create([
            'status_code' => $response->getStatusCode(),
        ]);

        $this->dispatchEvents();
    }

    protected function dispatchEvents()
    {
        if ($this->endpoint->status->isDown()) {
            event(new EndpointIsDown($this->endpoint));
        }

        if ($this->endpoint->isBackUp()) {
            event(new EndpointIsBackUp($this->endpoint));
        }
    }
}
