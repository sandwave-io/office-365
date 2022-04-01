<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Error;

final class ResponseErrorTransformer
{
    public static function transformXml(\SimpleXMLElement $xml): Error
    {
        $error = new Error();
        $error->setMessages(self::getMessages($xml));
        $error->setOriginalXml($xml);

        return $error;
    }

    public static function hasErrorState(\SimpleXMLElement $xml): bool
    {
        if (property_exists($xml, 'State')) {
            if ((string) $xml->State->Code === '0') {
                $xml->State->Code = 'success';
            }

            return strtolower((string) $xml->State->Code) !== 'success';
        }

        if (property_exists($xml, 'Status')) {
            return strtolower((string) $xml->Status->Code) !== 'success';
        }

        return false;
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

        $result = $xml->xpath('//*[local-name() = "Comments"]');

        if (count($result) > 0) {
            $xmlMessages = $result[0]->children();
        } else {
            $result = $xml->xpath('//*[local-name() = "Messages"]');

            if (count($result) > 0) {
                $xmlMessages = $result[0]->children();
            }
        }

        foreach ($xmlMessages as $message) {
            $messages[] = trim((string) $message);
        }

        return $messages;
    }
}
