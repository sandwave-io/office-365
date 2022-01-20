<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class Tenant implements EntityInterface
{
    private string $tenantName;

    /**
     * @param string $tenantName
     */
    public function __construct(string $tenantName)
    {
        $this->tenantName = $tenantName;
    }

    public function tenantName(): string
    {
        return $this->tenantName;
    }
}
