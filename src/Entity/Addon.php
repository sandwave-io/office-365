<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\CustomerHeader;

final class Addon implements EntityInterface
{
    private ?CustomerHeader $header = null;

    private int $parentOrderId;

    private string $productCode;

    private int $quantity;

    public function getHeader(): ?CustomerHeader
    {
        return $this->header;
    }

    public function setHeader(CustomerHeader $header): void
    {
        $this->header = $header;
    }

    public function getParentOrderId(): int
    {
        return $this->parentOrderId;
    }

    public function setParentOrderId(int $parentOrderId): void
    {
        $this->parentOrderId = $parentOrderId;
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function setProductCode(string $productCode): void
    {
        $this->productCode = $productCode;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
