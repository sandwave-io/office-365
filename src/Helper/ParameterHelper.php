<?php declare(strict_types=1);

namespace Kpn\Helper;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Yaml\Yaml;

class ParameterHelper
{
    private static array $parameters = [];

    public static function parse(): void
    {
        if (count(self::$parameters) > 0) {
            return;
        }

        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        $parameters = file_get_contents(__DIR__ . '/../../config/parameters.yaml');
        preg_match_all('/\%env\(resolve:([A-Za-z0-9\_\-]+)\)%/', $parameters, $matches);

        foreach ($matches[1] as $envKeyword) {
            $keyword = trim($envKeyword);
            $parameters = str_replace('%env(resolve:' . $keyword . ')%', $_ENV[$keyword], $parameters);
        }

        self::$parameters = Yaml::parse($parameters);
    }

    public static function get(string $name)
    {
        self::parse();
        return self::$parameters[$name];
    }
}
