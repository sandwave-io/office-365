<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Error;

final class ResponseErrorTransformer
{
    /**
     * @var array<string>
     */
    private static array $successStatuses = [
        'success', 'active', '0', 'accepted', 'modified',
    ];

    public static function transformXml(\SimpleXMLElement $xml): Error
    {
        $error = new Error();
        $error->setMessages(self::getMessages($xml));
        $error->setOriginalXml($xml);

        return $error;
    }

    public static function hasErrorState(\SimpleXMLElement $xml): bool
    {
        $statusCode = ResponseStatusTransformer::getStatusCode($xml);

        if ($statusCode !== '') {
            return ! in_array(strtolower($statusCode), self::$successStatuses, true);
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
