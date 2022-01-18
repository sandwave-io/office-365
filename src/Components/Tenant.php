<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use DOMException;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Response\TenantDomainOwnershipResponse;
use SandwaveIo\Office365\Response\TenantExistsResponse;
use SandwaveIo\Office365\Transformer\TenantDataBuilder;

final class Tenant extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function exists(string $tenantName): TenantExistsResponse
    {
        $tenantDomainOwnership = EntityHelper::deserializeArray(\SandwaveIo\Office365\Entity\Tenant::class, TenantDataBuilder::build($tenantName), RequestAction::TENANT_EXISTS_CHECK_REQUEST_V1);

        try {
            $document = EntityHelper::serialize($tenantDomainOwnership);
        } catch (\Exception $e) {
            throw new Office365Exception(sprintf('%s:exists unable to check tenant existence. Tenant %s.', self::class, $tenantName), 0, $e);
        }

        $route = $this->getRouter()->get('tenant_exists');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        $val = libxml_use_internal_errors();
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($body);
        libxml_use_internal_errors($val) ;

        if ($xml === false) {
            throw new Office365Exception(sprintf('%s:exists unable to check tenant existence. Tenant %s.', self::class, $tenantName));
        }

        if ((string) $xml->IsSuccess === 'false') {
            throw new Office365Exception(sprintf('%s:exists Nina error response returned %s, %s. Tenant %s.', self::class, $xml->ErrorCode, $xml->ErrorMessage, $tenantName));
        }

        return EntityHelper::deserializeXml(TenantExistsResponse::class, $body);
    }
}
