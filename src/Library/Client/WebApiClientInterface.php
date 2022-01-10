<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Library\Client;

use Psr\Http\Message\ResponseInterface;

interface WebApiClientInterface
{
    public function  request(string $method, string $url, string $xmlDocument): ResponseInterface;
}
