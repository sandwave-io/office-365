<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Transformer\ResponseStatusTransformer;

final class WebApiClient implements WebApiClientInterface
{
    private GuzzleClient $client;

    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * @throws Office365Exception
     */
    public function request(string $method, string $url, string $xmlDocument): ResponseInterface
    {
        try {
            return $this->client->request($method, $url, ['body' => $xmlDocument]);
        } catch (GuzzleException $e) {
            $errorCode = ResponseStatusTransformer::getStatusCode(new \SimpleXMLElement($xmlDocument));
            throw new Office365Exception($e->getMessage(), $errorCode, $e);
        }
    }
}
