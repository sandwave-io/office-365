<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Enum\RequestAction;

final class RootNodeTransformer
{
    public static function transform(string $rootNode): string
    {
        switch ($rootNode) {
            case RequestAction::NEW_CUSTOMER_RESPONSE_V3:
            case RequestAction::NEW_CUSTOMER_REQUEST_V3:
                return Event::CUSTOMER_CREATE;

            case RequestAction::MODIFY_CUSTOMER_REQUEST_V3:
            case RequestAction::MODIFY_CUSTOMER_RESPONSE_V3:
                return Event::CUSTOMER_MODIFY;

            case RequestAction::NEW_CLOUD_LICENSE_ORDER_REQUEST_V2:
            case RequestAction::NEW_CLOUD_LICENSE_ORDER_RESPONSE_V2:
                return Event::CLOUD_LICENSE_ORDER_CREATE;

            case RequestAction::NEW_CLOUD_LICENSE_ADDON_ORDER_RESPONSE_V1:
            case RequestAction::NEW_CLOUD_LICENSE_ADDON_ORDER_REQUEST_V1:
                return Event::CLOUD_LICENSE_ADDON_CREATE;

            case RequestAction::TERMINATE_ORDER_REQUEST_V2:
            case RequestAction::TERMINATE_ORDER_RESPONSE_V1:
                return Event::TERMINATE_ORDER;

            case RequestAction::MODIFY_ORDER_QUANTITY_RESPONSE_V1:
            case RequestAction::MODIFY_ORDER_QUANTITY_REQUEST_V1:
                return Event::ORDER_MODIFY_QUANTITY;

            default:
                return '';
        }
    }
}
