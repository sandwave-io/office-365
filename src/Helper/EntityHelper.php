<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Helper;

use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Library\Serializer\Serializer;
use SandwaveIo\Office365\Transformer\ClassTransformer;
use SimpleXMLElement;

final class EntityHelper
{
    private static ?Serializer $serializer = null;

    public static function serialize(EntityInterface $entity, ?string $tag = null): string
    {
        $serializer = self::createSerializer()->getSerializer();
        $xml = $serializer->serialize($entity, 'xml');

        if ($tag === null) {
            return $xml;
        }

        $simplexml = simplexml_load_string($xml);
        /** @var SimpleXMLElement $simplexml */
        return str_replace($simplexml->getName(), $tag, $xml);
    }

    public static function createSerializer(): Serializer
    {
        if (! self::$serializer instanceof Serializer) {
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
        $xml = XmlHelper::arrayToXml($data, self::createSerializer()->getRootNode($class));
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
     * @throws Office365Exception
     */
    public static function createFromXML(string $xml): ?EntityInterface
    {
        $simpleXml = XmlHelper::loadXML($xml);

        if ($simpleXml === null) {
            throw new Office365Exception('Could not convert XML');
        }

        $className = ClassTransformer::transform($simpleXml->getName());

        $data = XmlHelper::XmlToArray($xml);

        return EntityHelper::deserialize($className, $data);
    }
}
