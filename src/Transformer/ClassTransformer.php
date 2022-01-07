<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Entity\Customer as KpnCustomer;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Enum\RequestAction;

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
