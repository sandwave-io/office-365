<?php declare(strict_types=1);

namespace Kpn\Office\Endpoint;

use GuzzleHttp\Client;
use Kpn\Helper\ParameterHelper;

abstract class AbstractEndpoint
{
    private Client $client;

    public function __construct()
    {
        $config = ParameterHelper::get('kpn');

        $this->client = new Client(
            [
                'auth' => [$config['username'], $config['passwd']],
                'base_uri' => $config['base_uri']
            ]
        );
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
