<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Library\Observer\Status\Status;

final class ResponseStatusTransformer
{
    public static function transform(\SimpleXMLElement $simpleXml): Status
    {
        return new Status(
            self::getStatusCode($simpleXml),
            self::getMessages($simpleXml)
        );
    }

    public static function getStatusCode(\SimpleXMLElement $xml): string
    {
        if (property_exists($xml, 'State')) {
            return strtolower((string) $xml->State->Code);
        }

        if (property_exists($xml, 'Status')) {
            return strtolower((string) $xml->Status->Code);
        }

        return '';
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return array<string>
     */
    public static function getMessages(\SimpleXMLElement $xml): array
    {
        $messages = [];
        $xmlMessages = [];

        $result = $xml->xpath('//*[local-name() = "Comments" or local-name() = "Messages"]');

        if (count($result) > 0) {
            $xmlMessages = $result[0]->children();
        }

        foreach ($xmlMessages as $message) {
            $messages[] = trim((string) $message);
        }

        return $messages;
    }
}
