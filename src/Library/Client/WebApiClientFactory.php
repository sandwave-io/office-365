<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Client;

use GuzzleHttp\Client;
use SandwaveIo\Office365\Library\Parameter\ParameterContainerInterface;

final class WebApiClientFactory
{
    private ParameterContainerInterface $parameterContainer;

    public function __construct(ParameterContainerInterface $parameterContainer)
    {
        $this->parameterContainer = $parameterContainer;
    }

    /**
     * @param array<mixed> $options
     */
    public function create(array $options = []): WebApiClientInterface
    {
        $defaults = array_merge($options, [
            'auth' => [$this->parameterContainer->get('username'), $this->parameterContainer->get('password')],
            'base_uri' => $this->parameterContainer->get('host'),
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
        ]);

        $client = new Client($defaults);

        return new WebApiClient($client);
    }
}
