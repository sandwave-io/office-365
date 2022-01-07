<?php declare(strict_types=1);

namespace Office365\Library\Client;

use GuzzleHttp\Client;
use Office365\Library\Parameter\ParameterContainerInterface;

final class GuzzleClient
{
    private ParameterContainerInterface $parameterContainer;

    public function __construct(ParameterContainerInterface $parameterContainer)
    {
        $this->parameterContainer = $parameterContainer;
    }

    public function create(): Client
    {
        return new Client(
            [
                'auth' => [$this->parameterContainer->get('username'), $this->parameterContainer->get('password')],
                'base_uri' => $this->parameterContainer->get('host'),
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8',
                ],
            ]
        );
    }
}
