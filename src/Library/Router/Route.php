<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Router;

final class Route
{
    private string $method;

    private string $url;

    public function __construct(string $method, string $url)
    {
        $this->method = $method;
        $this->url = $url;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function url(): string
    {
        return $this->url;
    }
}
