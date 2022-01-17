<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class TenantDomainOwnershipResponse
{
    private RequestStatus $status;

    private bool $isDelegatedAccessAllowed;

    private bool $isAcceptanceMcaRequired;

    private bool $isOnboardingReady;

    private string $dnsBoardingRecordName;

    private string $dnsBoardingRecordValue;

    public function getStatus(): RequestStatus
    {
        return $this->status;
    }

    public function getIsDelegatedAccessAllowed(): bool
    {
        return $this->isDelegatedAccessAllowed;
    }

    public function getIsAcceptanceMcaRequired(): bool
    {
        return $this->isAcceptanceMcaRequired;
    }

    public function getIsOnboardingReady(): bool
    {
        return $this->isOnboardingReady;
    }

    public function getDnsBoardingRecordName(): string
    {
        return $this->dnsBoardingRecordName;
    }

    public function getDnsBoardingRecordValue(): string
    {
        return $this->dnsBoardingRecordValue;
    }
}
