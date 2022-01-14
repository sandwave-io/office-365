<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Header\CustomerHeader;
use SandwaveIo\Office365\Entity\CloudAgreementContact\AgreementContact;
use SandwaveIo\Office365\Helper\EntityHelper;

final class CloudAgreementContactDataBuilder
{
    /**
     * @return array<string, int|CustomerHeader|string|null>
     */
    public static function build(?CustomerHeader $customerHeader, int $customerId, AgreementContact $agreementContact): array
    {
        return [
            'Header' => EntityHelper::serialize($customerHeader),
            'CustomerId' => $customerId,
            'AgreementContact' => EntityHelper::serialize($agreementContact),
        ];
    }
}
