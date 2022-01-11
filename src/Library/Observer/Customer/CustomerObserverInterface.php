<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Customer;

use SandwaveIo\Office365\Entity\Customer;

interface CustomerObserverInterface
{
    public function execute(Customer $customer): void;
}
