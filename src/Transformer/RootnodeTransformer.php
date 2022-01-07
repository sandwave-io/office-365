<?php declare(strict_types=1);

namespace Office365\Transformer;

use Office365\Enum\Event;
use Office365\Enum\RequestAction;

class RootnodeTransformer
{
    public static function transform(string $rootNode): string
    {
        switch ($rootNode) {

            case RequestAction::NEW_CUSTOMER_REQUEST_V1:
                return Event::CUSTOMER_CREATE;
                break;
        }
    }
}
