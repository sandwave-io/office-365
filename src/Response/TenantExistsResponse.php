<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class TenantExistsResponse
{
    private bool $isExistingTenant;

    private RequestStatus $status;

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

    public function setStatus(RequestStatus $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): RequestStatus
    {
        return $this->status;
    }
}
