<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class TenantDataBuilder
{
    /**
     * @return array<string, string>
     */
    public static function build(string $tenantName): array
    {
        return [
            'TenantName' => $tenantName,
        ];
    }
}
