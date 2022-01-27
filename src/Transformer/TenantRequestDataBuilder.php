<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class TenantRequestDataBuilder
{
    /**
     * @return array<string, int>
     */
    public static function build(int $customerId): array
    {
        return [
            'CustomerId' => $customerId,
        ];
    }
}
