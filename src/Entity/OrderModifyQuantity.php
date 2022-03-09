<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class OrderModifyQuantity implements EntityInterface
{
    private ?PartnerReferenceHeader $header = null;

    private int $orderId;

    private ?int $quantity = null;

    private ?bool $delta = null;

    private ?int $upgradeOrderId = null;

    public function getHeader(): ?PartnerReferenceHeader
    {
        return $this->header;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function isDelta(): ?bool
    {
        return $this->delta;
    }

    public function getUpgradeOrderId(): ?int
    {
        return $this->upgradeOrderId;
    }
}
