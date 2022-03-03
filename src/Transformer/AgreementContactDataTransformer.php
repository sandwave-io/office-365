<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class AgreementContactDataTransformer
{
    /**
     * @return string[]
     */
    public static function transform(
        string $firstname,
        string $lastname,
        string $email,
        string $phonenumber,
        \DateTime $agreed
    ): array {
        return [
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'EmailAddress' => $email,
            'PhoneNumber' => $phonenumber,
            'DateAgreed' => $agreed->format('Y-m-d'),
        ];
    }
}
