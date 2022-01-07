<?php declare(strict_types=1);

namespace Office365\Library\Parameter;

interface ParameterContainerInterface
{
    public function get(string $key): ?string;

    public function set(string $key, string $value): void;
}
