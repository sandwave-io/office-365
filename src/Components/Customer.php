<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use DOMException;
use SandwaveIo\Office365\Entity\Customer as CustomerEntity;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Response\QueuedResponse;
use SandwaveIo\Office365\Transformer\CustomerDataBuilder;

final class Customer extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function create(
        string $name,
        string $street,
        int $houseNr,
        ?string $houseNrExtension,
        string $zipCode,
        string $city,
        string $countryCode,
        string $phone1,
        ?string $phone2,
        ?string $fax,
        string $email,
        ?string $website,
        ?string $debitNr,
        ?string $iban,
        ?string $bic,
        string $legalStatus,
        ?string $externalId,
        ?string $chamberOfCommerceNr): QueuedResponse
    {
        $customerData = CustomerDataBuilder::build(
            ... func_get_args()
        );

        $customer = EntityHelper::deserialize(CustomerEntity::class, $customerData);
        $document = EntityHelper::prepare(RequestAction::NEW_CUSTOMER_REQUEST_V1, $customer);
        if ($document === false) {
            throw new Office365Exception(self::class . ':create unable to create customer entity.');
        }

        $route = $this->getRouter()->get('customer_create');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);

        $xml = simplexml_load_string($response->getBody()->getContents());

        if ($xml === false) {
            throw new Office365Exception(self::class . ':create unable to create customer entity.');
        }

        return new QueuedResponse(
            (string) $xml->IsSuccess === 'true',
            (string) $xml->ErrorMessage,
            (int) $xml->ErrorCode
        );
    }
}
