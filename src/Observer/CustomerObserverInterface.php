<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Observer;

use SandwaveIo\Office365\Entity\Customer;

interface CustomerObserverInterface
{
    public function execute(Customer $customer): void;
}
