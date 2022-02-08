<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Error;

final class ErrorObserver implements \SplObserver
{
    private ErrorObserverInterface $callback;

    public function __construct(ErrorObserverInterface $callback)
    {
        $this->callback = $callback;
    }

    public function update(\SplSubject $subject): void
    {
        $this->callback->execute($subject->getError());
    }
}
