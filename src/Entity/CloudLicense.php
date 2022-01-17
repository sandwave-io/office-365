<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class CloudLicense implements EntityInterface
{
    private ?PartnerReferenceHeader $header = null;

    private AgreementContact $contact;

    private CloudTenant $tenant;

    public function getContact(): AgreementContact
    {
        return $this->contact;
    }

    public function getTenant(): CloudTenant
    {
        return $this->tenant;
    }

    public function getHeader(): ?PartnerReferenceHeader
    {
        return $this->header;
    }
}
