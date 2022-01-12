<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity\Header;

final class CustomerHeader
{
    /**
     * @Serializer\SerializedName("PartnerReference")
     * @Serializer\Type("int")
     */
    private int $partnerReference;

    /**
     * @Serializer\SerializedName("DateCreated")
     * @Serializer\Type("DateTime<'Y-m-d\TH:i:s'>")
     */
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
