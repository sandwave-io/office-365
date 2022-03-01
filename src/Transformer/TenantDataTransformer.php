<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\AgreementContact;

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
        AgreementContact $contact,
        string $tenantId = null
    ): array {
        return [
            'TenantId' => $tenantId,
            'TenantName' => $name,
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'EmailAddress' => $email,
            'CustomerAgreementContact' => $contact,
        ];
    }
}
