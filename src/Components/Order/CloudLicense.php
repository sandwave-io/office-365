<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components\Order;

use SandwaveIo\Office365\Components\AbstractComponent;
use SandwaveIo\Office365\Entity\CloudLicense as License;
use SandwaveIo\Office365\Entity\CloudTenant;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Helper\XmlHelper;
use SandwaveIo\Office365\Response\QueuedResponse;

final class CloudLicense extends AbstractComponent
{
    /**
     * @throws Office365Exception
     */
    public function create(
        string $customerId,
        string $productCode,
        int $quantity,
        string $partnerReference = '',
        CloudTenant $tenant = null
    ): QueuedResponse {
        /** @var License $license */
        $license = EntityHelper::deserialize(License::class, [
            'CustomerId' => $customerId,
            'ProductCode' => $productCode,
            'Quantity' => $quantity,
        ]);

        if ($tenant !== null) {
            $license->setCloudTenant($tenant);
        }

        if ($partnerReference !== '') {
            $license->setPartnerReferenceHeader(new PartnerReferenceHeader($partnerReference));
        }

        try {
            $document = EntityHelper::serialize($license);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to process cloud license create response', 0, $e);
        }

        $route = $this->getRouter()->get('order_license_create');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        $xml = XmlHelper::loadXML($body);

        if ($xml === null) {
            throw new Office365Exception(self::class . ':create xml is null');
        }

        return EntityHelper::deserializeXml(QueuedResponse::class, $body);
    }
}
