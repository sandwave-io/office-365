<?php declare(strict_types=1);

namespace Kpn\Transformer;

use Kpn\Entity\Customer as KpnCustomer;
use Kpn\Enum\Event;
use Kpn\Enum\RequestAction;

class ClassTransformer
{
    public static function transform(string $rootNode): string
    {
        switch ($rootNode) {

            case RequestAction::NEW_CUSTOMER_REQUEST_V1:
                return KpnCustomer::class;
                break;
        }
    }
}
