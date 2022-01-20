<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components\Order;

use SandwaveIo\Office365\Components\AbstractComponent;
use SandwaveIo\Office365\Library\Client\WebApiClientInterface;
use SandwaveIo\Office365\Library\Router\RouterInterface;

final class Order extends AbstractComponent
{
    public CloudLicense $cloudLicense;

    public function __construct(WebApiClientInterface $client, RouterInterface $router)
    {
        parent::__construct($client, $router);
        $this->cloudLicense = new CloudLicense($client, $router);
    }
}
