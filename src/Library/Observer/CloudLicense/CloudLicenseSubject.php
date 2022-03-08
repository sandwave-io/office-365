<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\CloudLicense;

use SandwaveIo\Office365\Entity\CloudLicense;
use SandwaveIo\Office365\Library\Observer\Subject\AbstractSubject;

final class CloudLicenseSubject extends AbstractSubject
{
    private CloudLicense $license;

    public function setCloudLicense(CloudLicense $license): void
    {
        $this->license = $license;
    }

    public function getCloudLicense(): CloudLicense
    {
        return $this->license;
    }
}
