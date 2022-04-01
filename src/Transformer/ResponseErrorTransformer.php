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
        $error->setMessages(ResponseStatusTransformer::getMessages($xml));
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
}
