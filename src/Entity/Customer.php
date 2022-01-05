<?php declare(strict_types=1);

namespace Kpn\Entity;

use Kpn\Entity\Header\CustomerHeader;

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
