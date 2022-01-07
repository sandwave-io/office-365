<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Office\Endpoint;

use SandwaveIo\Office365\Library\Client\WebApiClient;

abstract class AbstractEndpoint
{
    private WebApiClient $client;

    public function __construct(WebApiClient $client)
    {
        $this->client = $client;
    }

    public function getClient(): WebApiClient
    {
        return $this->client;
    }
}
