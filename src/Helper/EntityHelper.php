<?php declare(strict_types=1);

namespace Kpn\Helper;

use Kpn\Entity\EntityInterface;
use JMS\Serializer\SerializerBuilder;
use Kpn\Enum\RequestAction;
use LaLit\Array2XML;

class EntityHelper
{
    public static function serialize($object): string
    {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->serialize($object, 'xml');
    }

    public static function deserialize(string $class, array $data)
    {
        $xml = self::toXML($data, RequestAction::NEW_CUSTOMER_REQUEST_V1);

        $serializer = SerializerBuilder::create()
            ->addMetadataDir('./config/serializer')
            ->setDebug(true)
            ->build();

        return $serializer->deserialize($xml, $class, 'xml');
    }

    public static function prepare(string $action, EntityInterface $entity)
    {
        $header = '<?xml version="1.0"?>';
        $header .= '<' . $action . '></' . $action . '>';

        $doc = new \DOMDocument();
        $doc->loadXML($header, LIBXML_NOWARNING);

        $docCustomer = new \DOMDocument();
        $docCustomer->loadXML(self::serialize($entity), LIBXML_NOWARNING);

        $xpath = new \DOMXPath($docCustomer);
        $properties = $xpath->query('//result/*');

        foreach ($properties as $property) {
            $node = $doc->importNode($property, true);
            $doc->documentElement->appendChild($node);
        }

        return $doc->saveXML();
    }

    public static function toXML(array $data, string $action): string
    {
        return (Array2XML::createXML($action, $data))->saveXML();
    }
}
