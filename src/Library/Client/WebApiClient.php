<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Library\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Library\Parameter\ParameterContainerInterface;

final class WebApiClient
{
    private Client $client;

    private ParameterContainerInterface $parameterContainer;

    public function __construct(ParameterContainerInterface $parameterContainer)
    {
        $this->parameterContainer = $parameterContainer;

        $this->client = new Client(
            [
                'auth' => [$this->parameterContainer->get('username'), $this->parameterContainer->get('password')],
                'base_uri' => $this->parameterContainer->get('host'),
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8'
                ],
            ]
        );
    }

    public function request(string $method, string $url, string $xmlDocument): ResponseInterface
    {
        try {
            return $this->client->request($method, $url, ['body' => $xmlDocument]);
        } catch (\Exception $e) {
            throw new Office365Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
}
