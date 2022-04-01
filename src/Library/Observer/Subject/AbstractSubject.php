<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Subject;

use SandwaveIo\Office365\Library\Observer\Status\Status;
use SplObserver;

abstract class AbstractSubject implements \SplSubject
{
    private ?Status $status = null;

    private \SplObjectStorage $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    final public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    final public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    final public function notify(): void
    {
        foreach ($this->observers as $observer) {
            /** @var SplObserver $observer */
            $observer->update($this);
        }
    }

    final public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    final public function getStatus(): ?Status
    {
        return $this->status;
    }
}
