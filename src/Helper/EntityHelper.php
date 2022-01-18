<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Helper;

use Exception;
use LaLit\Array2XML;
use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Library\Serializer\Serializer;
use SandwaveIo\Office365\Transformer\ClassTransformer;

final class EntityHelper
{
    private static ?Serializer $serializer = null;

    public static function serialize(EntityInterface $entity): string
    {
        $serializer = self::createSerializer()->getSerializer();
        return $serializer->serialize($entity, 'xml');
    }

    public static function createSerializer(): Serializer
    {
        if (!self::$serializer instanceof Serializer) {
            self::$serializer = new Serializer();
        }

        return self::$serializer;
    }

    /**
     * @return mixed
     */
    public static function deserializeXml(string $class, string $xml)
    {
        $serializer = self::createSerializer()->getSerializer();
        return $serializer->deserialize($xml, $class, 'xml');
    }

    /**
     * @param array<mixed> $data
     *
     * @return mixed
     */
    public static function deserializeArray(string $class, array $data)
    {
        $xml = self::toXML($data, self::createSerializer()->getRootNode($class));
        $serializer = self::createSerializer()->getSerializer();

        return $serializer->deserialize($xml, $class, 'xml');
    }

    /**
     * @param array<mixed> $data
     *
     * @return mixed
     */
    public static function deserialize(string $class, array $data)
    {
        return self::deserializeArray($class, $data);
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
        $previousValue = libxml_use_internal_errors();

        libxml_use_internal_errors(true);

        $xml = simplexml_load_string($xml);

        if ($xml === false) {
            return null;
        }

        libxml_use_internal_errors($previousValue);

        $className = ClassTransformer::transform($xml->getName());

        return EntityHelper::deserialize($className, (array) $xml);
    }
}

