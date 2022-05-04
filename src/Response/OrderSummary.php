<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

use DateTime;

final class OrderSummary
{
    private int $orderId;

    private ?int $referenceOrderId;

    private ?int $parentId;

    private ?int $customerId;

    private string $productId;

    private string $productName;

    private string $productGroup;

    private string $productCommercialTypeName;

    private DateTime $dateCreated;

    private ?DateTime $dateActive;

    private ?DateTime $dateModified;

    private ?DateTime $dateTerminate;

    private ?DateTime $dateTerminated;

    private ?string $label;

    private ?string $attribute;

    private string $orderState;

    private int $quantity;

    private string $serviceLevelAgreement;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getReferenceOrderId(): ?int
    {
        return $this->referenceOrderId;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductGroup(): string
    {
        return $this->productGroup;
    }

    public function getProductCommercialTypeName(): string
    {
        return $this->productCommercialTypeName;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function getDateActive(): ?DateTime
    {
        return $this->dateActive;
    }

    public function getDateModified(): ?DateTime
    {
        return $this->dateModified;
    }

    public function getDateTerminate(): ?DateTime
    {
        return $this->dateTerminate;
    }

    public function getDateTerminated(): ?DateTime
    {
        return $this->dateTerminated;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getOrderState(): string
    {
        return $this->orderState;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getServiceLevelAgreement(): string
    {
        return $this->serviceLevelAgreement;
    }
}
