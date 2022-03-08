<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Customer;

use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Library\Observer\Subject\AbstractSubject;

final class CustomerSubject extends AbstractSubject
{
    private Customer $customer;

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
