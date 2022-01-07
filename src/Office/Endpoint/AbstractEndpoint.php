<?php declare(strict_types=1);

namespace Office365\Office\Endpoint;

use GuzzleHttp\Client;
use Office365\Helper\ParameterHelper;

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
