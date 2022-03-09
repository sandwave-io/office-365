<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Order;

use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SandwaveIo\Office365\Library\Observer\Status\Status;

interface OrderModifyQuantityObserverInterface
{
    public function execute(OrderModifyQuantity $modification, ?Status $status): void;
}
