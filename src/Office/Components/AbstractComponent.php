<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Office\Components;

use SandwaveIo\Office365\Library\Client\WebApiClient;
use SandwaveIo\Office365\Library\Client\WebApiClientInterface;
use SandwaveIo\Office365\Library\Router\RouterInterface;

abstract class AbstractComponent
{
    private WebApiClient $client;

    private RouterInterface $router;

    public function __construct(WebApiClientInterface $client, RouterInterface $router)
    {
        $this->client = $client;
        $this->router = $router;
    }

    public function getClient(): WebApiClient
    {
        return $this->client;
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
}
