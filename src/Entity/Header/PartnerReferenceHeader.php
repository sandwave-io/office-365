<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity\Header;

use SandwaveIo\Office365\Entity\EntityInterface;

final class PartnerReferenceHeader implements EntityInterface
{
    private string $partnerReference;

    private \DateTime $dateCreated;

    public function __construct(string $partnerReference, \DateTime $created = null)
    {
        $this->partnerReference = $partnerReference;
        $this->dateCreated = $created === null ? new \DateTime() : $created;
    }

    public function getPartnerReference(): string
    {
        return $this->partnerReference;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }
}
