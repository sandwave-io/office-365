<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\CloudLicense;

use SandwaveIo\Office365\Entity\CloudLicense;

interface CloudLicenseObserverInterface
{
    public function execute(CloudLicense $customer): void;
}
