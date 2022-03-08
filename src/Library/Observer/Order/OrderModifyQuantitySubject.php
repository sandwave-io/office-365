<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Order;

use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SandwaveIo\Office365\Library\Observer\Subject\AbstractSubject;

final class OrderModifyQuantitySubject extends AbstractSubject
{
    private OrderModifyQuantity $orderModifyQuantity;

    public function setOrderModifyQuantity(OrderModifyQuantity $modifyQuantity): void
    {
        $this->orderModifyQuantity = $modifyQuantity;
    }

    public function getOrderModifyQuantity(): OrderModifyQuantity
    {
        return $this->orderModifyQuantity;
    }
}
