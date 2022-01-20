<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Addon;

use SandwaveIo\Office365\Entity\Addon;
use SplObserver;

final class AddonSubject implements \SplSubject
{
    private \SplObjectStorage $observers;

    private Addon $addon;

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

    public function setAddon(Addon $addon): void
    {
        $this->addon = $addon;
    }

    public function getAddon(): Addon
    {
        return $this->addon;
    }
}
