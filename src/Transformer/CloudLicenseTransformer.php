<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\AgreementContact;
use SandwaveIo\Office365\Entity\CloudTenant;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class CloudLicenseTransformer
{
    /**
     * @param CloudTenant      $tenant
     * @param AgreementContact $contact
     * @param string           $partnerReference
     *
     * @return array<mixed>
     */
    public static function transform(CloudTenant $tenant, AgreementContact $contact, string $partnerReference): array
    {
        return [
            'CloudTenant_V2' => $tenant,
            'CustomerAgreementContact_V1' => $contact,
            'Header' => $partnerReference !== '' ? (new PartnerReferenceHeader($partnerReference)) : null,
        ];
    }
}
