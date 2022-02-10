<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Enum;

final class Event
{
    const CUSTOMER_CREATE = 'customer_create';

    const CUSTOMER_MODIFY = 'customer_modify';

    const CLOUD_LICENSE_ORDER_CREATE = 'cloud_license_order_create';

    const CLOUD_LICENSE_ADDON_CREATE = 'cloud_license_addon_create';

    const TERMINATE_ORDER = 'terminate-order';

    const ORDER_MODIFY_QUANTITY = 'order_modify_quantity';

    const CALLBACK_ERROR = 'callback_error';
}
