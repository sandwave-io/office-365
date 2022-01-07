<?php declare(strict_types=1);

namespace Office365\Office;

use Office365\Library\Client\GuzzleClient;
use Office365\Library\Parameter\ParameterContainer;
use Office365\Library\Parameter\ParameterContainerInterface;
use Office365\Observer\Subjects;
use Office365\Office\Endpoint\Customer;
use Office365\Webhook\Webhook;

final class OfficeClient
{
    public Customer $customer;

    public Webhook $webhook;

    private Subjects $subjects;

    private ParameterContainerInterface $parameterContainer;

    public function __construct(string $host, string $username, string $password)
    {
        $this->parameterContainer = new ParameterContainer([
            'host' => $host,
            'username' => $username,
            'password' => $password,
        ]);

        $guzzleClient = (new GuzzleClient($this->parameterContainer))->create();

        $this->customer = new Customer($guzzleClient);

        $this->subjects = new Subjects();
        $this->webhook = new Webhook($this->subjects);
    }
}
