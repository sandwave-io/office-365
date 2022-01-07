<?php declare(strict_types=1);

namespace Office365\Observer;

use Office365\Entity\Customer;

interface CustomerObserverInterface
{
    public function execute(Customer $customer): void;
}
