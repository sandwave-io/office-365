<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class TenantDataTransformer
{
    /**
     * @return string[]
     */
    public static function transform(string $tenantId, string $name, string $firstname, string $lastname, string $email): array
    {
        return [
            'TenantId' => $tenantId,
            'TenantName' => $name,
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'EmailAddress' => $email,
        ];
    }
}
