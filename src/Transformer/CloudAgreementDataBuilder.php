<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class CloudAgreementDataBuilder
{
    /**
     * @return string[]
     */
    public static function build(string $name): array
    {
        return [
            'Name' => $name,
        ];
    }
}
