<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\AgreementContact;
use SandwaveIo\Office365\Entity\CloudTenant;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;
use SandwaveIo\Office365\Helper\EntityHelper;

final class CloudLicenseTransformer
{
    public static function transform(CloudTenant $tenant, AgreementContact $contact, string $partnerReference): array
    {
        return [
            'CloudTenant_V2' => EntityHelper::serialize($tenant),
            'CustomerAgreementContact_V1' => EntityHelper::serialize($contact),
            'Header' => $partnerReference !== '' ? EntityHelper::serialize((new PartnerReferenceHeader($partnerReference))) : null
        ];
    }
}
