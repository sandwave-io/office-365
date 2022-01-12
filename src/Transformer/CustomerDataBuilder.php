<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class CustomerDataBuilder
{
    /**
     * @return array<string, int|string|null>
     */
    public static function build(
        string $name,
        string $street,
        int $houseNr,
        ?string $houseNrExtension,
        string $zipCode,
        string $city,
        string $countryCode,
        string $phone1,
        ?string $phone2,
        ?string $fax,
        string $email,
        ?string $website,
        ?string $debitNr,
        ?string $iban,
        ?string $bic,
        string $legalStatus,
        ?string $externalId,
        ?string $chamberOfCommerceNr
    ): array {
        return [
            'Name'   => $name,
            'Street' => $street,
            'HouseNr' => $houseNr,
            'HouseNrExtension' => $houseNrExtension,
            'ZipCode' => $zipCode,
            'City' => $city,
            'CountryCode' => $countryCode,
            'Phone1' => $phone1,
            'Phone2' => $phone2,
            'Fax' => $fax,
            'Email' => $email,
            'Website' => $website,
            'DebitNr' => $debitNr,
            'IBAN' => $iban,
            'BIC' => $bic,
            'LegalStatus' => $legalStatus,
            'ExternalId' => $externalId,
            'ChamberOfCommerceNr' => $chamberOfCommerceNr,
        ];
    }
}
