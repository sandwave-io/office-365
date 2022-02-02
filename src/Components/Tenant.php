<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use SandwaveIo\Office365\Entity\CloudTenant;
use SandwaveIo\Office365\Entity\CloudTenantRequest;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Helper\XmlHelper;
use SandwaveIo\Office365\Response\CloudTenantResponse;
use SandwaveIo\Office365\Response\TenantExistsResponse;
use SandwaveIo\Office365\Transformer\TenantDataBuilder;
use SandwaveIo\Office365\Transformer\TenantDataTransformer;
use SandwaveIo\Office365\Transformer\TenantRequestDataBuilder;

final class Tenant extends AbstractComponent
{
    /**
     * @throws Office365Exception
     */
    public function exists(string $tenantName): TenantExistsResponse
    {
        $tenantDomainOwnership = EntityHelper::deserializeArray(\SandwaveIo\Office365\Entity\Tenant::class, TenantDataBuilder::build($tenantName));

        try {
            $document = EntityHelper::serialize($tenantDomainOwnership);
        } catch (\RuntimeException $e) {
            throw new Office365Exception(sprintf('%s:exists unable to check tenant existence. Tenant %s.', self::class, $tenantName), 0, $e);
        }

        $route = $this->getRouter()->get('tenant_exists');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        $xml = Xmlhelper::loadXML($body);

        if ($xml === null) {
            throw new Office365Exception(sprintf('%s:exists unable to check tenant existence. Tenant %s.', self::class, $tenantName));
        }

        if ((string) $xml->IsSuccess === 'false') {
            throw new Office365Exception(sprintf('%s:exists Nina error response returned %s, %s. Tenant %s.', self::class, $xml->ErrorCode, $xml->ErrorMessage, $tenantName));
        }

        return EntityHelper::deserializeXml(TenantExistsResponse::class, $body);
    }

    /**
     * @throws Office365Exception
     */
    public function fetchTenant(int $customerId): CloudTenantResponse
    {
        $tenantRequest = EntityHelper::deserializeArray(CloudTenantRequest::class, TenantRequestDataBuilder::build($customerId));

        try {
            $document = EntityHelper::serialize($tenantRequest);
        } catch (\RuntimeException $e) {
            throw new Office365Exception(sprintf('%s:get unable to get tenant. Customer %s.', self::class, $customerId), 0, $e);
        }

        $route = $this->getRouter()->get('tenant_fetch_tenant');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        $xml = Xmlhelper::loadXML($body);

        if ($xml === null) {
            throw new Office365Exception(sprintf('%s:get unable to get tenant. Tenant %s.', self::class, $customerId));
        }

        if ((string) $xml->IsSuccess === 'false') {
            throw new Office365Exception(sprintf('%s:get Nina error response returned %s, %s. Tenant %s.', self::class, $xml->ErrorCode, $xml->ErrorMessage, $customerId));
        }

        return EntityHelper::deserializeXml(CloudTenantResponse::class, $body);
    }

    public function create(string $name, string $firstname, string $lastname, string $email, ?string $tenantId = null): CloudTenant
    {
        $tenant = EntityHelper::deserialize(CloudTenant::class, TenantDataTransformer::transform(...func_get_args()));

        if ($tenant === null) {
            throw new Office365Exception('Tenant could not be created');
        }

        return $tenant;
    }
}
