<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Terminate;

use SandwaveIo\Office365\Entity\Terminate;

interface TerminateObserverInterface
{
    public function execute(Terminate $terminate): void;
}
