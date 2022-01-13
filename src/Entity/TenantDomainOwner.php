<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class TenantDomainOwner implements EntityInterface
{
    private int $customerId;

    private string $tenantId;

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }
}
