<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity\Header;

final class CustomerHeader
{
    private int $partnerReference;

    private \DateTime $dateCreated;

    /**
     * @param int       $partnerReference
     * @param \DateTime $dateCreated
     */
    public function __construct(int $partnerReference, \DateTime $dateCreated)
    {
        $this->partnerReference = $partnerReference;
        $this->dateCreated = $dateCreated;
    }

    public function getPartnerReference(): int
    {
        return $this->partnerReference;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }
}
