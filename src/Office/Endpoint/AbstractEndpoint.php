<?php declare(strict_types=1);

namespace Kpn\Office\Endpoint;

use GuzzleHttp\Client;

abstract class AbstractEndpoint
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            [
                'auth' => ['username', 'password'],
                'base_uri' => 'http://httpbin.org'
            ]
        );
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
