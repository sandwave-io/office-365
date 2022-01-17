<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components\Order;

use SandwaveIo\Office365\Components\AbstractComponent;
use SandwaveIo\Office365\Entity\AgreementContact;
use SandwaveIo\Office365\Entity\CloudLicense as License;
use SandwaveIo\Office365\Entity\CloudTenant;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Response\QueuedResponse;
use SandwaveIo\Office365\Transformer\CloudLicenseTransformer;

final class CloudLicense extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function create(CloudTenant $tenant, AgreementContact $contact, string $partnerReference = ''): QueuedResponse
    {
        $license = EntityHelper::deserialize(License::class, []);
        $license->setCloudTenant($tenant);
        $license->setAgreementContact($contact);

        if ($partnerReference !== '') {
            $license->setPartnerReference(new PartnerReferenceHeader($partnerReference));
        }

        $document = EntityHelper::serialize($license);

        var_dump($document);
        exit;

        if ($document === false) {
            throw new Office365Exception(self::class . ':create unable to create cloud license entity.');
        }

        $route = $this->getRouter()->get('cloud_license_create');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);

        $xml = simplexml_load_string($response->getBody()->getContents());

        if ($xml === false) {
            throw new Office365Exception(self::class . ':create unable to process cloud license create response');
        }

        return new QueuedResponse(
            (string) $xml->IsSuccess === 'true',
            (string) $xml->ErrorMessage,
            (int) $xml->ErrorCode
        );

        return new QueuedResponse(true, '', 1);
    }
}
