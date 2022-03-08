<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Addon;

use SandwaveIo\Office365\Entity\Addon;
use SandwaveIo\Office365\Library\Observer\Office365SubjectInterface;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SplObserver;

final class AddonSubject implements Office365SubjectInterface, \SplSubject
{
    private \SplObjectStorage $observers;

    private Addon $addon;

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

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setAddon(Addon $addon): void
    {
        $this->addon = $addon;
    }

    public function getAddon(): Addon
    {
        return $this->addon;
    }
}
