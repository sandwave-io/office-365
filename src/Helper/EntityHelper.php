<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Helper;

use DOMException;
use Exception;
use JMS\Serializer\SerializerBuilder;
use LaLit\Array2XML;
use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Transformer\ClassTransformer;

final class EntityHelper
{
    public static function serialize(EntityInterface $entity): string
    {
        $serializer = SerializerBuilder::create()
            ->addMetadataDir(__DIR__ . '/../../config/serializer', 'SandwaveIo\Office365\Entity')
            ->build();

        return $serializer->serialize($entity, 'xml');
    }

    /**
     * @param array<mixed> $data
     *
     * @return mixed
     */
    public static function deserialize(string $class, array $data)
    {
        $xml = self::toXML($data, RequestAction::NEW_CUSTOMER_REQUEST_V1);
        $serializer = SerializerBuilder::create()
            ->addMetadataDir(__DIR__ . '/../../config/serializer', 'SandwaveIo\Office365\Entity')
            ->build();

        return $serializer->deserialize($xml, $class, 'xml');
    }

    /**
     * @param array<mixed> $data
     *
     * @throws Exception
     */
    public static function toXML(array $data, string $action): string
    {
        $xml = (Array2XML::createXML($action, $data))->saveXML();

        if ($xml === false) {
            return '';
        }

        return $xml;
    }

    public static function createFromXML(string $xml): ?EntityInterface
    {
        $xml = simplexml_load_string($xml);

        if ($xml === false) {
            return null;
        }

        $className = ClassTransformer::transform($xml->getName());

        return EntityHelper::deserialize($className, (array) $xml);
    }
}
