<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class TenantRequestDataBuilder
{
    /**
     * @return array<string, string>
     */
    public static function build(string $customerId): array
    {
        return [
            'CustomerId' => $customerId,
        ];
    }
}
