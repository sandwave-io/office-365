<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Helper;

use DOMException;
use Exception;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use LaLit\Array2XML;
use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Transformer\ClassTransformer;

final class EntityHelper
{
    public static function serialize(EntityInterface $entity): string
    {
        $serializer = self::createSerializer();
        return $serializer->serialize($entity, 'xml');
    }

    public static function createSerializer(): SerializerInterface
    {
        return SerializerBuilder::create()
            ->addMetadataDir(__DIR__ . '/../../config/serializer', 'SandwaveIo\Office365\Entity')
            ->addMetadataDir(__DIR__ . '/../../config/serializer/response', 'SandwaveIo\Office365\Response')
            ->build();
    }

    /**
     * @return mixed
     */
    public static function deserializeXml(string $class, string $xml)
    {
        $serializer = self::createSerializer();
        return $serializer->deserialize($xml, $class, 'xml');
    }

    /**
     * @param array<mixed> $data
     *
     * @return mixed
     */
    public static function deserializeArray(string $class, array $data, string $action)
    {
        $xml = self::toXML($data, $action);
        $serializer = self::createSerializer();
        return $serializer->deserialize($xml, $class, 'xml');
    }

    /**
     * @param array<mixed> $data
     *
     * @return mixed
     */
    public static function deserialize(string $class, array $data, string $action)
    {
        return self::deserializeArray($class, $data, $action);
    }

    /**
     * @throws DOMException
     *
     * @return false|string
     */
    public static function prepare(string $action, EntityInterface $entity)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        $root = $doc->createElement($action);
        $doc->appendChild($root);

        $docCustomer = new \DOMDocument();
        $docCustomer->loadXML(self::serialize($entity), LIBXML_NOWARNING);

        $xpath = new \DOMXPath($docCustomer);
        $properties = $xpath->query('//result/*');

        if (! $properties instanceof \DOMNodeList) {
            return false;
        }

        foreach ($properties as $property) {
            $node = $doc->importNode($property, true);
            $doc->documentElement->appendChild($node);
        }

        return $doc->saveXML();
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

    public static function createFromXML(string $xml, string $action)
    {
        $xml = simplexml_load_string($xml);

        if ($xml === false) {
            return null;
        }

        $className = ClassTransformer::transform($xml->getName());

        return EntityHelper::deserialize($className, (array) $xml, $action);
    }
}
