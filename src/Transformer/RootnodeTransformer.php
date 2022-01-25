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

            case RequestAction::NEW_CLOUD_LICENSE_ORDER_REQUEST_V2:
                return Event::CLOUD_LICENSE_ORDER_CREATE;

            case RequestAction::NEW_CLOUD_AGREEMENT_CONTACT_REQUEST_V1:
                return Event::CLOUD_AGREEMENT_CREATE;

            case RequestAction::NEW_CLOUD_LICENSE_ADDON_ORDER_REQUEST_V1:
                return Event::CLOUD_LICENSE_ADDON_CREATE;

            case RequestAction::MODIFY_ORDER_QUANTITY_REQUEST_V1:
                return Event::ORDER_MODIFY_QUANTITY;

            default:
                return '';
        }
    }
}
