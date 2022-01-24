<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class CloudTenantRequest implements EntityInterface
{
    private string $customerId;

    /**
     * @param string $customerId
     */
    public function __construct(string $customerId)
    {
        $this->customerId = $customerId;
    }

    public function customerId(): string
    {
        return $this->customerId;
    }
}
