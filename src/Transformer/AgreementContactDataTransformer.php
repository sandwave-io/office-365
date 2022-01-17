<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class AgreementContactDataTransformer
{
    /**
     * @return string[]
     */
    public static function transform(string $name, string $firstname, string $lastname, string $email, \DateTime $agreed): array
    {
        return [
            'TenantName' => $name,
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'EmailAddress' => $email,
            'DateAgreed' => $agreed->format('Y-m-d')
        ];
    }
}
