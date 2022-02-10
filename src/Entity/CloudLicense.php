<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class CloudLicense implements EntityInterface
{
    private ?PartnerReferenceHeader $header = null;

    private AgreementContact $contact;

    private CloudTenant $tenant;

    private string $customerId;

    private string $productCode;

    private int $quantity;

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

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
