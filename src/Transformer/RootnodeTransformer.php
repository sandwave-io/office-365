<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Enum\RequestAction;

final class RootnodeTransformer
{
    public static function transform(string $rootNode): string
    {
        switch ($rootNode) {
            case RequestAction::NEW_CUSTOMER_REQUEST_V1:
                return Event::CUSTOMER_CREATE;
            default:
                return "";
        }
    }
}
