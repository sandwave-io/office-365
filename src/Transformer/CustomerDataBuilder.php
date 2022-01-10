<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Transformer;

class CustomerDataBuilder
{
    public static function build(string $name): array
    {
        return [
            'Name' => $name,
        ];
    }
}
