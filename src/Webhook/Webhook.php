<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Webhook;

use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Helper\XmlHelper;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SandwaveIo\Office365\Library\Observer\Subjects;
use SandwaveIo\Office365\Library\Serializer\Serializer;
use SandwaveIo\Office365\Transformer\ResponseErrorTransformer;
use SandwaveIo\Office365\Transformer\ResponseStatusTransformer;
use SandwaveIo\Office365\Transformer\RootNodeTransformer;

/**
 * Class Webhook.
 *
 * @package SandwaveIo\Office365\Webhook
 *
 */
final class Webhook
{
    private Subjects $subjects;

    public function __construct(Subjects $subjects)
    {
        $this->subjects = $subjects;
    }

    /** @param mixed $callback */
    public function addEventSubscriber(string $type, $callback): void
    {
        $this->subjects->attach($type, $callback);
    }

    public function dispatch(string $event, Status $status, EntityInterface $entity = null): void
    {
        $subject = $this->subjects->getSubject($event, $entity);

        if ($subject !== null) {
            $subject->setStatus($status);
            $subject->notify();
        }
    }

    /**
     * @throws Office365Exception
     */
    public function process(string $xml): ?EntityInterface
    {
        $simpleXml = XmlHelper::loadXML($xml);

        if ($simpleXml === null) {
            throw new Office365Exception('Could not parse received XML');
        }

        $rootName = $simpleXml->getName();
        $eventName = RootNodeTransformer::transform($rootName);

        if (ResponseErrorTransformer::hasErrorState($simpleXml)) {
            $this->dispatch(
                $eventName,
                ResponseStatusTransformer::transform($simpleXml),
                ResponseErrorTransformer::transformXml($simpleXml)
            );

            return null;
        }

        $config = (new Serializer())->findConfigByRootname($rootName);

        if ($config === null) {
            throw new Office365Exception('Could not find matching config');
        }

        if ($config->getClassName() === null) {
            throw new Office365Exception('Could not create entity from received XML');
        }

        $entity = $config->getReferenceNode() !== null
            ? EntityHelper::deserializeArray(
                $config->getClassName(),
                XmlHelper::fetchChildNodes($config->getReferenceNode(), $simpleXml)
            )
            : EntityHelper::deserializeXml($config->getClassName(), $xml)
        ;

        $this->dispatch($eventName, ResponseStatusTransformer::transform($simpleXml), $entity);

        return $entity;
    }
}
