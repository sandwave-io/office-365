<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Order;

use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SplObserver;

final class OrderModifyQuantitySubject implements \SplSubject
{
    private \SplObjectStorage $observers;

    private OrderModifyQuantity $orderModifyQuantity;

    private ?Status $status = null;

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

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }
}
