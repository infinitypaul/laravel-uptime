<?php

namespace Infinitypaul\LaravelUptime\Events;

use Illuminate\Queue\SerializesModels;
use Infinitypaul\LaravelUptime\Endpoint;

class EndpointIsDown
{
    use SerializesModels;

    protected $endpoint;

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getEndpointStatuses()
    {
        return $this->endpoint->statuses;
    }

    public function getEndpointStatus()
    {
        return $this->endpoint->status;
    }
}
