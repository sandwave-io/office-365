<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Error;

use SandwaveIo\Office365\Entity\Error;
use SandwaveIo\Office365\Library\Observer\Office365SubjectInterface;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SplObserver;

final class ErrorSubject implements \SplSubject, Office365SubjectInterface
{
    private \SplObjectStorage $observers;

    private Error $error;

    private ?Status $status = null;

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

    public function setError(Error $error): void
    {
        $this->error = $error;
    }

    public function getError(): Error
    {
        return $this->error;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }
}
