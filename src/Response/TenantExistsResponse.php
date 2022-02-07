<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class TenantExistsResponse extends AbstractRealtimeResponse
{
    private bool $isExistingTenant;

    /**
     * @param bool $isExistingTenant
     */
    public function __construct(bool $isExistingTenant)
    {
        $this->isExistingTenant = $isExistingTenant;
    }

    public function isExistingTenant(): bool
    {
        return $this->isExistingTenant;
    }
}
