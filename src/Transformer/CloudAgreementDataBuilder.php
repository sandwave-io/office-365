<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;
use SandwaveIo\Office365\Entity\Header\CustomerHeader;
use SandwaveIo\Office365\Entity\CloudAgreementContact_V1\AgreementContact;

final class CloudAgreementDataBuilder
{
    /**
     * @return array<string, int|AgreementContact|CustomerHeader>
     */
    public static function build(CustomerHeader $customerHeader, int $customerId, AgreementContact $agreementContact): array
    {
        return [
            'CustomerHeader' => $customerHeader,
            'CustomerId' => $customerId,
            'AgreementContact' => $agreementContact,
        ];
    }
}
