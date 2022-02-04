<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class TenantDataTransformer
{
    /**
     * @return array<string, string|null>
     */
    public static function transform(
        string $name,
        string $firstname,
        string $lastname,
        string $email,
        string $tenantId = null
    ): array {
        return [
            'TenantId' => $tenantId,
            'TenantName' => $name,
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'EmailAddress' => $email,
        ];
    }
}
