<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Error;

final class ResponseErrorTransformer
{
    public static function transformXml(\SimpleXMLElement $xml): Error
    {
        $messages = [];

        foreach ($xml->Status->Messages as $message) {
            if (property_exists($message, 'string')) {
                $messages[] = trim((string) $message->string);
            }
        }

        $error = new Error();
        $error->setMessages($messages);

        return $error;
    }
}
