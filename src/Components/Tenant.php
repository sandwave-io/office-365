<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use DOMException;
use SandwaveIo\Office365\Entity\TenantDomainOwner;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Response\RequestStatus;
use SandwaveIo\Office365\Response\TenantDomainOwnershipResponse;
use SandwaveIo\Office365\Transformer\TenantDataBuilder;

final class Tenant extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function hasTenantDomainOwnership(int $customerId, string $tenantId): TenantDomainOwnershipResponse
    {
        $tenantDomainOwnership = EntityHelper::deserialize(TenantDomainOwner::class, TenantDataBuilder::build($customerId, $tenantId), RequestAction::TENANT_DOMAIN_OWNERSHIP_REQUEST_V1);
        $document = EntityHelper::prepare(RequestAction::TENANT_DOMAIN_OWNERSHIP_REQUEST_V1, $tenantDomainOwnership);
        if ($document === false) {
            throw new Office365Exception(sprintf('%s:hasDomainOwnership unable to check tenant domain ownership. Tenant %s, customer %s.', self::class, $tenantId, $customerId));
        }

        $route = $this->getRouter()->get('tenant_ownership_has_domain_ownership');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);

        $xml = simplexml_load_string($response->getBody()->getContents());

        if ($xml === false) {
            throw new Office365Exception(sprintf('%s:hasDomainOwnership unable to check tenant domain ownership. Tenant %s, customer %s.', self::class, $tenantId, $customerId));
        }

        if ((string) $xml->IsSuccess === 'false') {
            throw new Office365Exception(sprintf('%s:hasDomainOwnership Nina error response returned %s, %s. Tenant %s, customer %s.', self::class, $xml->ErrorCode, $xml->ErrorMessage, $tenantId, $customerId));
        }

        return new TenantDomainOwnershipResponse(
            new RequestStatus(
                (string) $xml->Status->Code,
                (array) $xml->Status->Messages
            ),
            boolval($xml->IsDelegatedAccessAllowed),
            boolval($xml->IsAcceptanceMcaRequired),
            boolval($xml->IsOnboardingReady),
            (string) $xml->DnsBoardingRecordName,
            (string) $xml->DnsBoardingRecordValue,
        );
    }
}
