<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Components;

use SandwaveIo\Office365\Library\Client\WebApiClientInterface;
use SandwaveIo\Office365\Library\Router\RouterInterface;

abstract class AbstractComponent
{
    private WebApiClientInterface $client;

    private RouterInterface $router;

    public function __construct(WebApiClientInterface $client, RouterInterface $router)
    {
        $this->client = $client;
        $this->router = $router;
    }

    public function getClient(): WebApiClientInterface
    {
        return $this->client;
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
}
