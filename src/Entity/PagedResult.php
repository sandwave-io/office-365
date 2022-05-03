<?php declare(strict_types = 1);


use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Response\OrderSummary;

final class PagedResult implements EntityInterface
{
    private int $total;

    /**
     * @var array<OrderSummary>
     */
    private array $results;

    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array<OrderSummary>
     */
    public function getResults(): array
    {
        return $this->results;
    }
}
