<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Helper;

final class XmlHelper
{
    /**
     * @param string $xml
     *
     * @return array<string>
     */
    public static function XmlToArray(string $xml): array
    {
        $simpleXml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($simpleXml);

        if ($json === false) {
            return [];
        }

        return json_decode($json, true);
    }

    public static function loadXML(string $xml): ?\SimpleXMLElement
    {
        $previousValue = libxml_use_internal_errors();

        libxml_use_internal_errors(true);

        $simpleXml = simplexml_load_string($xml, 'SimpleXMLElement');

        if ($simpleXml === false) {
            return null;
        }

        libxml_use_internal_errors($previousValue);

        return $simpleXml;
    }

    /**
     * @param array<mixed> $data
     * @param string       $rootNode
     * @param mixed|null   $simpleXmlElement
     *
     * @return string
     */
    public static function arrayToXml(array $data, string $rootNode, &$simpleXmlElement = null): string
    {
        if ($simpleXmlElement === null) {
            $simpleXmlElement = new \SimpleXMLElement('<?xml version="1.0"?><' . $rootNode . '/>');
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key;
                }

                $subNode = $simpleXmlElement->addChild($key);
                self::arrayToXml($value, $rootNode, $subNode);
            } else {
                if ($value !== null) {
                    $simpleXmlElement->addChild("$key", htmlspecialchars("$value"));
                }
            }
        }

        return $simpleXmlElement->saveXML();
    }
}
