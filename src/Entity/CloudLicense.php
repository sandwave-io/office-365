<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class CloudLicense implements EntityInterface
{
    private ?PartnerReferenceHeader $partnerReferenceHeader = null;

    private AgreementContact $contact;

    private CloudTenant $tenant;

    private ?int $orderId = null;

    private string $customerId;

    private string $productCode;

    private int $quantity;

    private ?string $status = null;

    public function getAgreementContact(): AgreementContact
    {
        return $this->contact;
    }

    public function getCloudTenant(): CloudTenant
    {
        return $this->tenant;
    }

    /**
     * @deprecated use getPartnerReferenceHeader
     */
    public function getHeader(): ?PartnerReferenceHeader
    {
        return $this->getPartnerReferenceHeader();
    }

    public function setCloudTenant(CloudTenant $tenant): void
    {
        $this->tenant = $tenant;
    }

    public function getPartnerReferenceHeader(): ?PartnerReferenceHeader
    {
        return $this->partnerReferenceHeader;
    }

    public function setPartnerReferenceHeader(PartnerReferenceHeader $header): void
    {
        $this->partnerReferenceHeader = $header;
    }

    public function setAgreementContact(AgreementContact $contact): void
    {
        $this->contact = $contact;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }
}
