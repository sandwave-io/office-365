<?php declare(strict_types=1);

namespace Kpn\Office\Endpoint;

use Kpn\Enum\RequestAction;
use Kpn\Helper\EntityHelper;
use Kpn\Entity\Customer as KpnCustomer;

class Customer extends AbstractEndpoint
{
    public function create(string $xml): KpnCustomer
    {
        $customer = EntityHelper::deserialize(KpnCustomer::class, $xml);

        // validate
        //..


        $document = EntityHelper::prepare(RequestAction::NEW_CUSTOMER_REQUEST_V1, $customer);

        $this->getClient()->post('/foo', [
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ],
            'body' => $document,
        ]);
    }
}
