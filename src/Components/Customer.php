<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use DOMException;
use SandwaveIo\Office365\Entity\Customer as CustomerEntity;
use SandwaveIo\Office365\Entity\TenantDomainOwner;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Helper\XmlHelper;
use SandwaveIo\Office365\Response\QueuedResponse;
use SandwaveIo\Office365\Response\TenantDomainOwnershipResponse;
use SandwaveIo\Office365\Transformer\CustomerDataBuilder;
use SandwaveIo\Office365\Transformer\TenantDomainOwnerDataBuilder;

final class Customer extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function hasTenantDomainOwnership(int $customerId, string $tenantId): TenantDomainOwnershipResponse
    {
        $tenantDomainOwnership = EntityHelper::deserializeArray(TenantDomainOwner::class, TenantDomainOwnerDataBuilder::build($customerId, $tenantId));

        try {
            $document = EntityHelper::serialize($tenantDomainOwnership);
        } catch (\Exception $e) {
            throw new Office365Exception(sprintf('%s:hasDomainOwnership unable to check tenant domain ownership. Tenant %s, customer %s.', self::class, $tenantId, $customerId), 0, $e);
        }

        $route = $this->getRouter()->get('customer_has_domain_ownership');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();

        $xml = XmlHelper::loadXML($body);

        if ($xml === null) {
            throw new Office365Exception(sprintf('%s:hasDomainOwnership unable to check tenant domain ownership. Tenant %s, customer %s.', self::class, $tenantId, $customerId));
        }

        if ((string) $xml->IsSuccess === 'false') {
            throw new Office365Exception(sprintf('%s:hasDomainOwnership Nina error response returned %s, %s. Tenant %s, customer %s.', self::class, $xml->ErrorCode, $xml->ErrorMessage, $tenantId, $customerId));
        }

        return EntityHelper::deserializeXml(TenantDomainOwnershipResponse::class, $body);
    }

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
        ?string $chamberOfCommerceNr
    ): QueuedResponse {
        $customerData = CustomerDataBuilder::build(
            null,
            ... func_get_args()
        );

        $customer = EntityHelper::deserialize(CustomerEntity::class, $customerData);

        try {
            $document = EntityHelper::serialize($customer);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to create customer entity.', 0, $e);
        }

        $route = $this->getRouter()->get('customer_create');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        var_dump($body);
        $xml = XmlHelper::loadXML($body);

        if ($xml === null) {
            throw new Office365Exception(self::class . ':create unable to create customer entity.');
        }

        return EntityHelper::deserializeXml(QueuedResponse::class, $body);
    }
//
//    public function modify(
//        string $customerId,
//        string $name,
//        string $street,
//        ?int $houseNr,
//        ?string $houseNrExtension,
//        string $zipCode,
//        string $city,
//        string $countryCode,
//        ?string $phone1,
//        ?string $phone2,
//        ?string $fax,
//        ?string $email,
//        ?string $website,
//        ?string $debitNr,
//        ?string $iban,
//        ?string $bic,
//        ?string $legalStatus,
//        ?string $externalId,
//        ?string $chamberOfCommerceNr
//    ): QueuedResponse
//    {
//        $customerData = CustomerDataBuilder::build(
//            ... func_get_args()
//        );
//
//
//    }
}
