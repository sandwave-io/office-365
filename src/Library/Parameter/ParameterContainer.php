<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Parameter;

final class ParameterContainer implements ParameterContainerInterface
{
    /** @var string[]  */
    private array $container = [];

    /**
     * @param string[] $keyValuePairs
     */
    public function __construct(array $keyValuePairs)
    {
        foreach ($keyValuePairs as $key => $value) {
            $this->container[$key] = $value;
        }
    }

    public function get(string $key): ?string
    {
        if (array_key_exists($key, $this->container)) {
            return $this->container[$key];
        }

        return null;
    }

    public function set(string $key, string $value): void
    {
        $this->container[$key] = $value;
    }
}
