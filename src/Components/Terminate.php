<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use DateTime;
use SandwaveIo\Office365\Entity\Terminate as TerminateEntity;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Helper\XmlHelper;
use SandwaveIo\Office365\Response\QueuedResponse;
use SandwaveIo\Office365\Transformer\TerminateDataBuilder;

final class Terminate extends AbstractComponent
{
    /**
     * @throws Office365Exception
     */
    public function create(
        string $orderId,
        DateTime $desiredTerminateDate,
        bool $terminateAsSoonAsPossible
    ): QueuedResponse {
        $terminationData = TerminateDataBuilder::build(
            ... func_get_args()
        );

        $terminate = EntityHelper::deserialize(TerminateEntity::class, $terminationData);

        try {
            $document = EntityHelper::serialize($terminate);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to create terminate entity.', 0, $e);
        }

        $route = $this->getRouter()->get('terminate_order');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        $xml = XmlHelper::loadXML($body);

        if ($xml === null) {
            throw new Office365Exception(self::class . ':create xml could not be loaded for terminate.');
        }

        return EntityHelper::deserializeXml(QueuedResponse::class, $body);
    }
}
