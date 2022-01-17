<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\AgreementContact;
use SandwaveIo\Office365\Entity\CloudTenant;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class CloudLicenseTransformer
{
    public static function transform(CloudTenant $tenant, AgreementContact $contact, string $partnerReference): array
    {
        var_dump([
            'CloudTenant_V2' => (array) $tenant,
            'CustomerAgreementContact_V1' => (array) $contact,
            'Header' => (array) $partnerReference !== '' ? (new PartnerReferenceHeader($partnerReference)) : null
        ]);


        return [
            'CloudTenant_V2' => (array) $tenant,
            'CustomerAgreementContact_V1' => (array) $contact,
            'Header' => (array) $partnerReference !== '' ? (new PartnerReferenceHeader($partnerReference)) : null
        ];
    }
}
