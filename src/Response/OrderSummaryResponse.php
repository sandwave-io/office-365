<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class OrderSummaryResponse extends AbstractRealtimeResponse
{
    private PagedResultOfOrderSummary $pagedResult;

    public function getPagedResult(): PagedResultOfOrderSummary
    {
        return $this->pagedResult;
    }
}
