<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

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
