<?php declare(strict_types=1);

namespace Kpn\Office\Endpoint;

use Kpn\Enum\RequestAction;
use Kpn\Helper\EntityHelper;
use Kpn\Entity\Customer as KpnCustomer;
use Kpn\Transformer\ArrayToCustomer;

class Customer extends AbstractEndpoint
{
    public function create(string $name): KpnCustomer
    {
        $customer = EntityHelper::deserialize(KpnCustomer::class, ArrayToCustomer::transform($name));

        $document = EntityHelper::prepare(RequestAction::NEW_CUSTOMER_REQUEST_V1, $customer);

        try {
            $this->getClient()->post('/foo', [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8',
                ],
                'body' => $document,
            ]);
        } catch (\Exception $e) {}

        return $customer;
    }
}
