<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class Addon implements EntityInterface
{
    private ?PartnerReferenceHeader $header = null;

    private int $parentOrderId;

    private string $productCode;

    private int $quantity;

    private ?string $licenseKey = null;

    public function getHeader(): ?PartnerReferenceHeader
    {
        return $this->header;
    }

    public function setHeader(PartnerReferenceHeader $header): void
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

    public function getLicenseKey(): string
    {
        return $this->licenseKey;
    }
}
