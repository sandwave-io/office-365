<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Office\Components;

use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Entity\Customer as KpnCustomer;
use SandwaveIo\Office365\Transformer\ArrayToCustomer;

final class Customer extends AbstractComponent
{
    public function create(string $name, string $partnerReference): KpnCustomer
    {
        $customer = EntityHelper::deserialize(KpnCustomer::class, ArrayToCustomer::transform($partnerReference, $name));
        $document = EntityHelper::prepare(RequestAction::NEW_CUSTOMER_REQUEST_V1, $customer);

        $route = $this->getRouter()->get('customer_create');
        $this->getClient()->request($route->method(), $route->url(), $document);

        return $customer;
    }
}
