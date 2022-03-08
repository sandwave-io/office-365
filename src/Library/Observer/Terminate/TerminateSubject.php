<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Terminate;

use SandwaveIo\Office365\Entity\Terminate;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SplObserver;

final class TerminateSubject implements \SplSubject
{
    private \SplObjectStorage $observers;

    private Terminate $terminate;

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

    public function setTerminate(Terminate $terminate): void
    {
        $this->terminate = $terminate;
    }

    public function getTerminate(): Terminate
    {
        return $this->terminate;
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
