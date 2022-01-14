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
use SandwaveIo\Office365\Transformer\CloudAgreementContactDataBuilder;

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
        $cloudAgreementData = CloudAgreementContactDataBuilder::build(
            ... func_get_args()
        );

        var_dump($cloudAgreementData);

        $contact = EntityHelper::deserialize(CloudAgreementContactEntity::class, $cloudAgreementData, RequestAction::NEW_CLOUD_AGREEMENT_CONTACT_REQUEST_V1);
        $document = EntityHelper::prepare(RequestAction::NEW_CLOUD_AGREEMENT_CONTACT_REQUEST_V1, $contact);
        if ($document === false) {
            throw new Office365Exception(self::class . ':create unable to create cloud contact agreement entity.');
        }

        $route = $this->getRouter()->get('contact_create');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);

        $xml = simplexml_load_string($response->getBody()->getContents());

        if ($xml === false) {
            throw new Office365Exception(self::class . ':create unable to create object from cloud agreement contact xml.');
        }

        return new QueuedResponse(
            (string) $xml->IsSuccess === 'true',
            (string) $xml->ErrorMessage,
            (int) $xml->ErrorCode
        );
    }
}
