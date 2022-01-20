<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Contact;

final class ContactObserver implements \SplObserver
{
    private ContactObserverInterface $callback;

    public function __construct(ContactObserverInterface $callback)
    {
        $this->callback = $callback;
    }

    public function update(\SplSubject $subject): void
    {
        /** @var ContactSubject $subject */
        $this->callback->execute($subject->getContact());
    }
}
