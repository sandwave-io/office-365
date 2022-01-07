<?php declare(strict_types=1);

namespace Office365\Entity;

use Office365\Entity\Header\CustomerHeader;

class Customer implements EntityInterface
{
    private CustomerHeader $header;

    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function getHeader(): CustomerHeader
    {
        return $this->header;
    }
}
