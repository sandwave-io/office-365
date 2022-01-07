<?php declare(strict_types=1);

namespace Office365\Observer;

class CustomerObserver implements \SplObserver
{
    private CustomerObserverInterface $callback;

    public function __construct(CustomerObserverInterface $callback)
    {
        $this->callback = $callback;
    }

    public function update(\SplSubject $subject)
    {
        $this->callback->execute($subject->getCustomer());
    }
}
