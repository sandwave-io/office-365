<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Office\Endpoint;

use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Entity\Customer as KpnCustomer;
use SandwaveIo\Office365\Transformer\ArrayToCustomer;

class Customer extends AbstractEndpoint
{
    public function create(string $name): KpnCustomer
    {
        $customer = EntityHelper::deserialize(KpnCustomer::class, ArrayToCustomer::transform('123456', $name));
        $document = EntityHelper::prepare(RequestAction::NEW_CUSTOMER_REQUEST_V1, $customer);

        //$this->getClient()->request('post', 'myroute', $document);

        return $customer;
    }
}
