<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use DateTime;

final class OrderSummary implements EntityInterface
{
    private ?int $customerId = null;

    private ?string $orderState = null;

    private ?string $productGroup = null;

    private ?string $productName = null;

    private ?DateTime $dateActiveFrom = null;

    private ?DateTime $dateActiveTo = null;

    private ?DateTime $dateModifiedFrom = null;

    private ?DateTime $dateModifiedTo = null;

    private ?string $label = null;

    private ?string $attribute = null;

    private ?int $skip = null;

    private ?int $take = null;

    private ?int $quantity = null;

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function getOrderState(): ?string
    {
        return $this->orderState;
    }

    public function getProductGroup(): ?string
    {
        return $this->productGroup;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function getDateActiveFrom(): ?DateTime
    {
        return $this->dateActiveFrom;
    }

    public function getDateActiveTo(): ?DateTime
    {
        return $this->dateActiveTo;
    }

    public function getDateModifiedFrom(): ?DateTime
    {
        return $this->dateModifiedFrom;
    }

    public function getDateModifiedTo(): ?DateTime
    {
        return $this->dateModifiedTo;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getSkip(): ?int
    {
        return $this->skip;
    }

    public function getTake(): ?int
    {
        return $this->take;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
