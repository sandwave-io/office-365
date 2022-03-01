<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class TenantDataTransformer
{
    /**
     * @param array<string> $contact
     * @return array<string, array<string,string>|string|null>
     */
    public static function transform(
        string $name,
        string $firstname,
        string $lastname,
        string $email,
        array $contact,
        string $tenantId = null
    ): array {
        return [
            'TenantId' => $tenantId,
            'TenantName' => $name,
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'EmailAddress' => $email,
            'CustomerAgreementContact' => [
                'FirstName' => $contact['firstname'],
                'LastName' => $contact['lastname'],
                'EmailAddress' => $contact['email'],
                'PhoneNumber' => $contact['phoneNumber'],
                'DateAgreed' => $contact['agreed'],
            ],
        ];
    }
}
