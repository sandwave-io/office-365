<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Addon;

final class AddonObserver implements \SplObserver
{
    private AddonObserverInterface $callback;

    public function __construct(AddonObserverInterface $callback)
    {
        $this->callback = $callback;
    }

    public function update(\SplSubject $subject): void
    {
        /** @var AddonSubject $subject */
        $this->callback->execute($subject->getAddon(), $subject->getStatus());
    }
}
