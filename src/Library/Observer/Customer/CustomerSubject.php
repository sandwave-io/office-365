<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Customer;

use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Library\Observer\Office365SubjectInterface;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SplObserver;

final class CustomerSubject implements \SplSubject, Office365SubjectInterface
{
    private \SplObjectStorage $observers;

    private Customer $customer;

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

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
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
