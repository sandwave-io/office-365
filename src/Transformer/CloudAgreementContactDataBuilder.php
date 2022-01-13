<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Header\CustomerHeader;
use SandwaveIo\Office365\Entity\CloudAgreementContact\AgreementContact;

final class CloudAgreementContactDataBuilder
{
    /**
     * @return array<string, int|AgreementContact|CustomerHeader>
     */
    public static function build(CustomerHeader $customerHeader, int $customerId, AgreementContact $agreementContact): array
    {
        return [
            'CustomerHeader' => $customerHeader,
            'CustomerId' => $customerId,
            'contact' => $agreementContact,
        ];
    }
}
