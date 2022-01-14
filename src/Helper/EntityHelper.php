<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Helper;

use DOMException;
use Exception;
use JMS\Serializer\SerializerBuilder;
use LaLit\Array2XML;
use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Transformer\ClassTransformer;

final class EntityHelper
{
    public static function serialize(EntityInterface $entity): string
    {
        $serializer = SerializerBuilder::create()->build();

        return $serializer->serialize($entity, 'xml');
    }

    /**
     * @param array<mixed> $data
     *
     * @return mixed
     */
    public static function deserialize(string $class, array $data, string $action)
    {
        var_dump('wtfffff');
        $xml = self::toXML($data, $action);
        $serializer = SerializerBuilder::create()
            ->addMetadataDir(__DIR__ . '/../../config/serializer', 'SandwaveIo\Office365\Entity')
            ->build();

        return $serializer->deserialize($xml, $class, 'xml');
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
        //var_dump('wtfff2ff');
//        var_dump(gettype($data));
        $xml = (Array2XML::createXML($action, $data))->saveXML();

        if ($xml === false) {
            return '';
        }

        return $xml;
    }

    public static function createFromXML(string $xml, string $action): ?EntityInterface
    {
        $xml = simplexml_load_string($xml);

        if ($xml === false) {
            return null;
        }

        $className = ClassTransformer::transform($xml->getName());

        return EntityHelper::deserialize($className, (array) $xml, $action);
    }
}
