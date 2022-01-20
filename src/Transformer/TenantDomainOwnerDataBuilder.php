<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class TenantDomainOwnerDataBuilder
{
    /**
     * @return array<string, string|int>
     */
    public static function build(int $customerId, string $tenantId): array
    {
        return [
            'CustomerId' => $customerId,
            'TenantId' => $tenantId,
        ];
    }
}
