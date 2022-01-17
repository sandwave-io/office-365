<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use DOMException;
use SandwaveIo\Office365\Entity\CloudAgreementContact\AgreementContact;
use SandwaveIo\Office365\Entity\CloudAgreementContact as CloudAgreementContactEntity;
use SandwaveIo\Office365\Entity\Header\CustomerHeader;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Response\QueuedResponse;

final class CloudAgreementContact extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function create(
        ?CustomerHeader $header,
        int $customerId,
        AgreementContact $contact
    ): QueuedResponse {
        $cloudAgreement = EntityHelper::deserialize(CloudAgreementContactEntity::class, [], RequestAction::NEW_CLOUD_AGREEMENT_CONTACT_REQUEST_V1);
        $cloudAgreement->setCustomerId($customerId);
        $cloudAgreement->setContact($contact);

        if ($header !== null) {
            $cloudAgreement->setHeader($header);
        }

        try {
            $document = EntityHelper::serialize($cloudAgreement);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to create cloud contact agreement entity.', 0, $e);
        }

        $route = $this->getRouter()->get('contact_create');
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
    }
}
