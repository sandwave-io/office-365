<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Library\Router;

use Symfony\Component\Yaml\Yaml;

final class Router implements RouterInterface
{
    private string $routeName = '%s_%s';

    private array $routes = [];

    public function __construct()
    {
        $data = Yaml::parseFile(__DIR__ . '/../../../config/routes.yaml');

        foreach ($data as $component => $routes) {
            foreach ($routes as $routeName => $route) {
                $this->set(
                    sprintf($this->routeName, $component, $routeName),
                    $route['method'],
                    $route['url'],
                );
            }
        }
    }

    public function set(string $name, string $method, string $route): void
    {
        $this->routes[$name] = new Route($method, $route);
    }

    public function get(string $name): Route
    {
        return $this->routes[$name];
    }
}
