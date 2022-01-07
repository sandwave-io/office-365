<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Library\Observer\Customer;

use SandwaveIo\Office365\Entity\Customer;

class CustomerSubject implements \SplSubject {

    private \SplObjectStorage $observers;

    private Customer $customer;

    public function __construct() {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer) {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer) {
        $this->observers->detach($observer);
    }

    public function notify() {
        foreach ($this->observers as $observer) {
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
