<?php declare(strict_types=1);

namespace Office365\Helper;

use GuzzleHttp\Client;

class GuzzleClientHelper
{
    public static function create(string $host, string $username, string $password)
    {
        return new Client(
            [
                'auth' => [$username, $password],
                'base_uri' => $host,
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8',
                ],
            ]
        );
    }
}
