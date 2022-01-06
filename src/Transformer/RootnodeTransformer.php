<?php declare(strict_types=1);

namespace Kpn\Transformer;

use Kpn\Enum\Event;
use Kpn\Enum\RequestAction;

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
