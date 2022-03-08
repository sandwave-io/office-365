<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Addon;

use SandwaveIo\Office365\Entity\Addon;
use SandwaveIo\Office365\Library\Observer\Status\Status;

interface AddonObserverInterface
{
    public function execute(Addon $addon, ?Status $statusCode): void;
}
