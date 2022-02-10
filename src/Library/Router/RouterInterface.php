<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Router;

interface RouterInterface
{
    public function get(string $name): Route;
}
