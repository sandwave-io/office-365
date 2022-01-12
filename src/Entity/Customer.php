<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\CustomerHeader;
use JMS\Serializer\Annotation as Serializer;

final class Customer implements EntityInterface
{
    private ?CustomerHeader $header = null;

    /**
     * @Serializer\SerializedName("Name")
     * @Serializer\Type("string")
     */
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function getHeader(): ?CustomerHeader
    {
        return $this->header;
    }
}
