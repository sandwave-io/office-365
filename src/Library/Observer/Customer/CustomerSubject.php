<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Customer;

use SandwaveIo\Office365\Entity\Customer;
use SplObserver;

final class CustomerSubject implements \SplSubject
{

    private \SplObjectStorage $observers;

    private Customer $customer;

    public function __construct() {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(SplObserver $observer): void {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void {
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
}
