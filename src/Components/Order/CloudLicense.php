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
     * @return QueuedResponse
     * @throws Office365Exception
     */
    public function create(CloudTenant $tenant, AgreementContact $contact, string $customerId, string $productCode, int $quantity, string $partnerReference = ''): QueuedResponse
    {
        $license = EntityHelper::deserialize(License::class, [
            'CustomerId' => $customerId,
            'ProductCode' => $productCode,
            'Quantity' => $quantity
        ]);

        $license->setCloudTenant($tenant);
        $license->setAgreementContact($contact);

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

        try {
            $xml = simplexml_load_string($response->getBody()->getContents());
        } catch(\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to process cloud license create response', 0, $e);
        }

        return new QueuedResponse(
            (string) $xml->IsSuccess === 'true',
            (string) $xml->ErrorMessage,
            (int) $xml->ErrorCode
        );
    }
}
