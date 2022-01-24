<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Order;

use SandwaveIo\Office365\Entity\OrderModifyQuantity;

final class OrderModifyQuantityObserver implements \SplObserver
{
    private OrderModifyQuantityObserverInterface $callback;

    public function __construct(OrderModifyQuantityObserverInterface $callback)
    {
        $this->callback = $callback;
    }

    public function update(\SplSubject $subject): void
    {
        /** @var OrderModifyQuantity $subject */
        $this->callback->execute($subject->getOrderModifyQuantity());
    }
}