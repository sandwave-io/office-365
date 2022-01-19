<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use DOMException;
use SandwaveIo\Office365\Entity\Addon as AddonEntity;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Response\QueuedResponse;
use SandwaveIo\Office365\Transformer\AddonDataBuilder;

final class CloudLicenseAddon extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function create(
        int $parentOrderId,
        string $productCode,
        int $quantity
    ): QueuedResponse {
        $customerData = AddonDataBuilder::build(
            ... func_get_args()
        );

        $customer = EntityHelper::deserialize(AddonEntity::class, $customerData, RequestAction::NEW_CLOUD_LICENSE_ADDON_ORDER_REQUEST_V1);
        $document = EntityHelper::prepare(RequestAction::NEW_CLOUD_LICENSE_ADDON_ORDER_REQUEST_V1, $customer);
        if ($document === false) {
            throw new Office365Exception(self::class . ':create unable to create addon entity.');
        }

        $route = $this->getRouter()->get('addon_create');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        $xml = simplexml_load_string($body);

        if ($xml === false) {
            throw new Office365Exception(self::class . ':create xml could not be loaded for addon.');
        }

        return EntityHelper::deserializeXml(QueuedResponse::class, $body);
    }
}
