<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components\Order;

use SandwaveIo\Office365\Components\AbstractComponent;
use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SandwaveIo\Office365\Entity\Terminate as TerminateEntity;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Helper\XmlHelper;
use SandwaveIo\Office365\Library\Client\WebApiClientInterface;
use SandwaveIo\Office365\Library\Router\RouterInterface;
use SandwaveIo\Office365\Response\OrderSummaryResponse;
use SandwaveIo\Office365\Response\QueuedResponse;
use SandwaveIo\Office365\Transformer\OrderModifyQuantityBuilder;
use SandwaveIo\Office365\Transformer\TerminateDataBuilder;
use SandwaveIo\Office365\Transformer\OrderSummaryBuilder;

final class Order extends AbstractComponent
{
    public CloudLicense $cloudLicense;

    public function __construct(WebApiClientInterface $client, RouterInterface $router)
    {
        parent::__construct($client, $router);
        $this->cloudLicense = new CloudLicense($client, $router);
    }

    /**
     * @throws Office365Exception
     */
    public function modify(int $orderId, int $quantity, bool $isDelta = false, string $partnerReference = ''): QueuedResponse
    {
        $modification = EntityHelper::deserialize(
            OrderModifyQuantity::class,
            OrderModifyQuantityBuilder::build(...func_get_args())
        );

        try {
            $document = EntityHelper::serialize($modification);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to process order quantity modification', 0, $e);
        }

        $route = $this->getRouter()->get('order_modify');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();

        try {
            $xml = XmlHelper::loadXML($body);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to process order modify response', 0, $e);
        }

        if ($xml === null) {
            throw new Office365Exception(self::class . ':create unable to process order modify response');
        }

        return EntityHelper::deserializeXml(QueuedResponse::class, $body);
    }

    /**
     * @throws Office365Exception
     */
    public function terminate(
        string $orderId,
        \DateTime $desiredTerminateDate,
        bool $terminateAsSoonAsPossible,
        string $partnerReference = ''
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

    /**
     * @throws Office365Exception
     */
    public function summary(
        int $customerId,
        string $orderState,
        string $productGroup,
        \DateTime $dateActiveFrom,
        \DateTime $dateActiveTo,
        \DateTime $dateModifiedFrom,
        \DateTime $dateModifiedTo,
        string $label,
        string $attribute,
        int $skip,
        int $take
    ): OrderSummaryResponse {
        $summaryData = OrderSummaryBuilder::build(
            ... func_get_args()
        );

        $summary = EntityHelper::deserialize(TerminateEntity::class, $summaryData);

        try {
            $document = EntityHelper::serialize($summary);
        } catch (\Exception $e) {
            throw new Office365Exception(self::class . ':create unable to create summary entity.', 0, $e);
        }

        $route = $this->getRouter()->get('summary_order');
        $response = $this->getClient()->request($route->method(), $route->url(), $document);
        $body = $response->getBody()->getContents();
        $xml = XmlHelper::loadXML($body);

        if ($xml === null) {
            throw new Office365Exception(self::class . ':create xml could not be loaded for summary.');
        }

        return EntityHelper::deserializeXml(OrderSummaryResponse::class, $body);
    }
}
