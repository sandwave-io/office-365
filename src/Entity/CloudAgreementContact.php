<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class CloudAgreementContact implements EntityInterface
{
    private ?PartnerReferenceHeader $header = null;

    private int $customerId;

    private AgreementContact $contact;

    public function getHeader(): ?PartnerReferenceHeader
    {
        return $this->header;
    }

    public function setHeader(PartnerReferenceHeader $header): void
    {
        $this->header = $header;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getContact(): AgreementContact
    {
        return $this->contact;
    }

    public function setContact(AgreementContact $contact): void
    {
        $this->contact = $contact;
    }
}
