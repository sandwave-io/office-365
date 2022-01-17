<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class CloudLicense implements EntityInterface
{
    private ?PartnerReferenceHeader $header = null;

    private AgreementContact $contact;

    private CloudTenant $tenant;

    public function getAgreementContact(): AgreementContact
    {
        return $this->contact;
    }

    public function getCloudTenant(): CloudTenant
    {
        return $this->tenant;
    }

    public function getHeader(): ?PartnerReferenceHeader
    {
        return $this->header;
    }

    public function setCloudTenant(CloudTenant $tenant): void
    {
        $this->tenant = $tenant;
    }

    public function setPartnerReferenceHeader(PartnerReferenceHeader $header): void
    {
        $this->header = $header;
    }

    public function setAgreementContact(AgreementContact $contact): void
    {
        $this->contact = $contact;
    }
}
