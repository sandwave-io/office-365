<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

use SandwaveIo\Office365\Entity\CloudTenant;

final class CloudTenantResponse
{
    private CloudTenant $cloudTenant;

    private RequestStatus $status;


    public function getTenant(): CloudTenant
    {
        return $this->cloudTenant;
    }

    public function setTenant(CloudTenant $cloudTenant): void
    {
        $this->cloudTenant = $cloudTenant;
    }

    public function getStatus(): RequestStatus
    {
        return $this->status;
    }

    public function setStatus(RequestStatus $status): void
    {
        $this->status = $status;
    }
}
