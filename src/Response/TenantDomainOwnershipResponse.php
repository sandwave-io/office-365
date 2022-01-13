<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

use SandwaveIo\Office365\Entity\RequestStatus;

final class TenantDomainOwnershipResponse
{
    private RequestStatus $status;

    private bool $isDelegatedAccessAllowed;

    private bool $isAcceptanceMcaRequired;

    private bool $isOnboardingReady;

    private string $dnsBoardingRecordName;

    private string $dnsBoardingRecordValue;

    /**
     * @param RequestStatus $status
     * @param bool          $isDelegatedAccessAllowed
     * @param bool          $isAcceptanceMcaRequired
     * @param bool          $isOnboardingReady
     * @param string        $dnsBoardingRecordName
     * @param string        $dnsBoardingRecordValue
     */
    public function __construct(RequestStatus $status, bool $isDelegatedAccessAllowed, bool $isAcceptanceMcaRequired, bool $isOnboardingReady, string $dnsBoardingRecordName, string $dnsBoardingRecordValue)
    {
        $this->status = $status;
        $this->isDelegatedAccessAllowed = $isDelegatedAccessAllowed;
        $this->isAcceptanceMcaRequired = $isAcceptanceMcaRequired;
        $this->isOnboardingReady = $isOnboardingReady;
        $this->dnsBoardingRecordName = $dnsBoardingRecordName;
        $this->dnsBoardingRecordValue = $dnsBoardingRecordValue;
    }

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
