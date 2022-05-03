<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Response\OrderSummary as OrderSummaryResponse;

final class PagedResult implements EntityInterface
{
    private int $total;

    /**
     * @var array<OrderSummaryResponse>
     */
    private array $results;

    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array<OrderSummaryResponse>
     */
    public function getResults(): array
    {
        return $this->results;
    }
}
