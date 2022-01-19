<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Addon;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Enum\RequestAction;

final class ClassTransformer
{
    public static function transform(string $rootNode): ?string
    {
        switch ($rootNode) {
            case RequestAction::NEW_CUSTOMER_REQUEST_V1:
                return Customer::class;
            case RequestAction::NEW_CLOUD_LICENSE_ADDON_ORDER_REQUEST_V1:
                return Addon::class;
            default:
                return null;
        }
    }
}
