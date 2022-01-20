<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\CloudLicense;

use SandwaveIo\Office365\Entity\CloudLicense;
use SplObserver;

final class CloudLicenseSubject implements \SplSubject
{
    private \SplObjectStorage $observers;

    private CloudLicense $license;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            /** @var SplObserver $observer */
            $observer->update($this);
        }
    }

    public function setCloudLicense(CloudLicense $license): void
    {
        $this->license = $license;
    }

    public function getCloudLicense(): CloudLicense
    {
        return $this->license;
    }
}
