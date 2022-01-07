<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Entity\Header;

class CustomerHeader
{
    private int $partnerReference;

    private \DateTime $dateCreated;

    public function getPartnerReference(): int
    {
        return $this->partnerReference;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }
}
