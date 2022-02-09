<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Error;

final class ResponseErrorTransformer
{
    public static function transformXml(\SimpleXMLElement $xml): Error
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

        $error = new Error();
        $error->setMessages($messages);

        return $error;
    }
}
