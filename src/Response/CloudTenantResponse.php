<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

use SandwaveIo\Office365\Entity\CloudTenant;

final class CloudTenantResponse extends AbstractRealtimeResponse
{
    private CloudTenant $cloudTenant;

    public function getTenant(): CloudTenant
    {
        return $this->cloudTenant;
    }

    public function setTenant(CloudTenant $cloudTenant): void
    {
        $this->cloudTenant = $cloudTenant;
    }
}
