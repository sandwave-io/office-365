<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Terminate;

use SandwaveIo\Office365\Entity\Terminate;
use SandwaveIo\Office365\Library\Observer\Subject\AbstractSubject;

final class TerminateSubject extends AbstractSubject
{
    private Terminate $terminate;

    public function setTerminate(Terminate $terminate): void
    {
        $this->terminate = $terminate;
    }

    public function getTerminate(): Terminate
    {
        return $this->terminate;
    }
}
