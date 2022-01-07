<?php declare(strict_types=1);

namespace Office365\Office\Endpoint;

use Office365\Enum\RequestAction;
use Office365\Exception\Office365Exception;
use Office365\Helper\EntityHelper;
use Office365\Entity\Customer as KpnCustomer;
use Office365\Transformer\ArrayToCustomer;

class Customer extends AbstractEndpoint
{
    public function create(string $name): KpnCustomer
    {
        $customer = EntityHelper::deserialize(KpnCustomer::class, ArrayToCustomer::transform($name));

        $document = EntityHelper::prepare(RequestAction::NEW_CUSTOMER_REQUEST_V1, $customer);

        try {
            $this->getClient()->post('/foo', [
                'body' => $document,
            ]);

        } catch (\Exception $e) {
            throw new Office365Exception("Network error", $e->getCode(), $e);
        }

        return $customer;
    }
}
