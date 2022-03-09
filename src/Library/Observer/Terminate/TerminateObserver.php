<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Terminate;

final class TerminateObserver implements \SplObserver
{
    private TerminateObserverInterface $callback;

    public function __construct(TerminateObserverInterface $callback)
    {
        $this->callback = $callback;
    }

    public function update(\SplSubject $subject): void
    {
        /** @var TerminateSubject $subject */
        $this->callback->execute($subject->getTerminate(), $subject->getStatus());
    }
}
