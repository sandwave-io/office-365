<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Helper;

class XmlHelper
{
    /**
     * @param string $xml
     * @return array<string>
     */
    public static function XmlToArray(string $xml): array
    {
        $simpleXml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
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

        $simpleXml = simplexml_load_string($xml, "SimpleXMLElement");

        if ($simpleXml === false) {
            return null;
        }

        libxml_use_internal_errors($previousValue);

        return $simpleXml;
    }
}
