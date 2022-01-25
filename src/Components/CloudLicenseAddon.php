<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use SandwaveIo\Office365\Entity\Addon as AddonEntity;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Helper\XmlHelper;
use SandwaveIo\Office365\Response\QueuedResponse;
use SandwaveIo\Office365\Transformer\AddonDataBuilder;

final class CloudLicenseAddon extends AbstractComponent
{
    /**
     * @throws Office365Exception
     */
    public function create(
        int $parentOrderId,
        string $productCode,
        int $quantity
    ): QueuedResponse {
        $addonData = AddonDataBuilder::build(
            ... func_get_args()
        );

        $addon = EntityHelper::deserialize(AddonEntity::class, $addonData);

        try {
            $document = EntityHelper::serialize($addon);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to create addon entity.', 0, $e);
        }

        $route = $this->getRouter()->get('addon_create');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        $xml = XmlHelper::loadXML($body);

        if ($xml === null) {
            throw new Office365Exception(self::class . ':create xml could not be loaded for addon.');
        }

        return EntityHelper::deserializeXml(QueuedResponse::class, $body);
    }
}
