<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity\Header;

use SandwaveIo\Office365\Entity\EntityInterface;

final class CustomerHeader implements EntityInterface
{
    private int $partnerReference;

    private \DateTime $dateCreated;

    public function __construct(int $partnerReference, \DateTime $dateCreated)
    {
        $this->partnerReference = $partnerReference;
        $this->dateCreated = $dateCreated;
    }

    public function getPartnerReference(): int
    {
        return $this->partnerReference;
    }

    public function setPartnerReference(int $partnerReference): void
    {
        $this->partnerReference = $partnerReference;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }
}
