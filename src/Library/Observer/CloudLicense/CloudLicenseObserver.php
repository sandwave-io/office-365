<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\CloudLicense;

final class CloudLicenseObserver implements \SplObserver
{
    private CloudLicenseObserverInterface $callback;

    public function __construct(CloudLicenseObserverInterface $callback)
    {
        $this->callback = $callback;
    }

    public function update(\SplSubject $subject): void
    {
        /** @var CloudLicenseSubject $subject */
        $this->callback->execute($subject->getCloudLicense(), $subject->getStatus());
    }
}
