<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Office\Endpoint;

use GuzzleHttp\Client;

abstract class AbstractEndpoint
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
