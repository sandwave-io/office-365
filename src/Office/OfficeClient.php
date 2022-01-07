<?php declare(strict_types=1);

namespace Office365\Office;

use Office365\Helper\GuzzleClientHelper;
use Office365\Observer\Subjects;
use Office365\Office\Endpoint\Customer;
use Office365\Webhook\Webhook;

final class OfficeClient
{
    public Customer $customer;

    public Webhook $webhook;

    private Subjects $subjects;

    public function __construct(string $host, string $username, string $password)
    {
        $guzzleClient = GuzzleClientHelper::create($host, $username, $password);

        $this->customer = new Customer($guzzleClient);

        $this->subjects = new Subjects();
        $this->webhook = new Webhook($this->subjects);
    }
}
