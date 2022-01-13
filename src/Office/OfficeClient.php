<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Office;

use SandwaveIo\Office365\Components\Customer;
use SandwaveIo\Office365\Components\Tenant;
use SandwaveIo\Office365\Library\Client\WebApiClientFactory;
use SandwaveIo\Office365\Library\Observer\Subjects;
use SandwaveIo\Office365\Library\Parameter\ParameterContainer;
use SandwaveIo\Office365\Library\Parameter\ParameterContainerInterface;
use SandwaveIo\Office365\Library\Router\Router;
use SandwaveIo\Office365\Library\Router\RouterInterface;
use SandwaveIo\Office365\Webhook\Webhook;

final class OfficeClient
{
    public Customer $customer;

    public Webhook $webhook;

    private Subjects $subjects;

    private ParameterContainerInterface $parameterContainer;

    private RouterInterface $router;

    /**
     * @param array<mixed> $webApiOptions
     */
    public function __construct(string $host, string $username, string $password, array $webApiOptions = [])
    {
        $this->parameterContainer = new ParameterContainer([
            'host' => $host,
            'username' => $username,
            'password' => $password,
        ]);

        $this->router = new Router();

        $webApiClient = (new WebApiClientFactory($this->parameterContainer))->create($webApiOptions);

        $this->customer = new Customer($webApiClient, $this->router);

        $this->subjects = new Subjects();
        $this->webhook = new Webhook($this->subjects);
    }
}
