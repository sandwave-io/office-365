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

    const ROOT_NODE_ERROR = 'root_node_error';

    const NEW_CUSTOMER_DECLINED = 'new_customer_declined';

    const MODIFY_CUSTOMER_DECLINED = 'modify_customer_declined';

    const ORDER_DECLINED = 'order_declined';

    const MODIFY_ORDER_DECLINED = 'modify_declined';

    const TERMINATE_ORDER_DECLINED = 'terminate_order_declined';
}
