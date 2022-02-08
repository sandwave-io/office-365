<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Error;

use SandwaveIo\Office365\Entity\Error;

interface ErrorObserverInterface
{
    public function execute(Error $error): void;
}
