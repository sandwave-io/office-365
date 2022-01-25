<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Order;

use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SplObserver;

final class OrderModifyQuantitySubject implements \SplSubject
{
    private \SplObjectStorage $observers;

    private OrderModifyQuantity $orderModifyQuantity;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            /** @var SplObserver $observer */
            $observer->update($this);
        }
    }

    public function setOrderModifyQuantity(OrderModifyQuantity $modifyQuantity): void
    {
        $this->orderModifyQuantity = $modifyQuantity;
    }

    public function getOrderModifyQuantity(): OrderModifyQuantity
    {
        return $this->orderModifyQuantity;
    }
}
