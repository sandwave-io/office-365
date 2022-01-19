<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components\Order;

use SandwaveIo\Office365\Components\AbstractComponent;
use SandwaveIo\Office365\Entity\AgreementContact;
use SandwaveIo\Office365\Entity\CloudLicense as License;
use SandwaveIo\Office365\Entity\CloudTenant;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Response\QueuedResponse;

final class CloudLicense extends AbstractComponent
{
    /**
     * @throws Office365Exception
     *
     * @return QueuedResponse
     */
    public function create(CloudTenant $tenant, AgreementContact $contact, string $customerId, string $productCode, int $quantity, string $partnerReference = ''): QueuedResponse
    {
        $license = EntityHelper::deserialize(License::class, [
            'CustomerId' => $customerId,
            'ProductCode' => $productCode,
            'Quantity' => $quantity,
        ]);

        $tenant->setAgreementContact($contact);
        $license->setCloudTenant($tenant);

        if ($partnerReference !== '') {
            $license->setPartnerReference(new PartnerReferenceHeader($partnerReference));
        }

        try {
            $document = EntityHelper::serialize($license);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to process cloud license create response', 0, $e);
        }

        $route = $this->getRouter()->get('order_license_create');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();

        try {
            $xml = simplexml_load_string($body);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to process cloud license create response', 0, $e);
        }

        if ($xml === false) {
            throw new Office365Exception(self::class . ':create unable to process cloud license create response');
        }

        return EntityHelper::deserializeXml(QueuedResponse::class, $body);
    }
}
