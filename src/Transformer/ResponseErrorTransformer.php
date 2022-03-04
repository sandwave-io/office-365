<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Error;

final class ResponseErrorTransformer
{
    /**
     * @var array<string> $successStatuses
     */
    private static array $successStatuses = [
        'success', 'active', '0'
    ];

    public static function transformXml(\SimpleXMLElement $xml): Error
    {
        $error = new Error();
        $error->setMessages(self::getMessages($xml));

        return $error;
    }

    public static function hasErrorState(\SimpleXMLElement $xml): bool
    {
        if (self::getStatusCode($xml) !== '') {
            return !in_array(strtolower((string) $xml->Status->Code), self::$successStatuses, true);
        }

        return false;
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

        if (property_exists($xml, 'Status')) {
            $xmlMessages = $xml->Status->Messages->string;
        } elseif (property_exists($xml, 'State')) {
            $xmlMessages = $xml->State->Comments->string;
        }

        foreach ($xmlMessages as $message) {
            $messages[] = trim((string) $message);
        }

        return $messages;
    }
}
