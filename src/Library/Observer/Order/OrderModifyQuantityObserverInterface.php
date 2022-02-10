<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Order;

use SandwaveIo\Office365\Entity\OrderModifyQuantity;

interface OrderModifyQuantityObserverInterface
{
    public function execute(OrderModifyQuantity $modification): void;
}
