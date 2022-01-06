<?php declare(strict_types=1);

namespace Kpn\Office;

use Kpn\Observer\Subjects;
use Kpn\Office\Endpoint\Customer;
use Kpn\Webhook\Webhook;

final class OfficeClient
{
    public Customer $customer;

    public Webhook $webhook;

    private Subjects $subjects;

    public function __construct()
    {
        $this->customer = new Customer();
        $this->subjects = new Subjects();
        $this->webhook = new Webhook($this->subjects);
    }
}
