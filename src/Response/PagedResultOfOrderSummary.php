<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class PagedResultOfOrderSummary
{
    private int $skip;

    private int $take;

    private int $totalNumberOfRecords;

    private OrderSummary $results;

    public function getSkip(): int
    {
        return $this->skip;
    }

    public function getTake(): int
    {
        return $this->take;
    }

    public function getTotalNumberOfRecords(): int
    {
        return $this->totalNumberOfRecords;
    }

    public function getResults(): OrderSummary
    {
        return $this->results;
    }
}
