<?php declare(strict_types=1);

namespace Kpn\Office;

use Kpn\Office\Endpoint\Customer;

final class OfficeClient
{
    public Customer $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }
}
