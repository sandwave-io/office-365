<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer;

use SandwaveIo\Office365\Library\Observer\Status\Status;

interface Office365SubjectInterface
{
    public function getStatus(): ?Status;

    public function setStatus(Status $status): void;
}
