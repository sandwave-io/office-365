<?php declare(strict_types=1);

namespace Kpn\Observer;

use Kpn\Entity\Customer;

interface CustomerObserverInterface
{
    public function execute(Customer $customer): void;
}
