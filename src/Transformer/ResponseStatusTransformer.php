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
     * @return array<string>
     */
    public static function getMessages(\SimpleXMLElement $xml): array
    {
        $messages = [];
        $xmlMessages = null;

        if (property_exists($xml, 'Status')) {
            $xmlMessages = $xml->Status->Messages->string;
        } elseif (property_exists($xml, 'State')) {
            $xmlMessages = $xml->State->Comments->string;
        }

        if ($xmlMessages === null) {
            return [];
        }

        foreach ($xmlMessages as $message) {
            $messages[] = trim((string) $message);
        }

        return $messages;
    }
}
