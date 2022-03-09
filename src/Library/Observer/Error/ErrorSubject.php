<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Error;

use SandwaveIo\Office365\Entity\Error;
use SandwaveIo\Office365\Library\Observer\Subject\AbstractSubject;

final class ErrorSubject extends AbstractSubject
{
    private Error $error;

    public function setError(Error $error): void
    {
        $this->error = $error;
    }

    public function getError(): Error
    {
        return $this->error;
    }
}
