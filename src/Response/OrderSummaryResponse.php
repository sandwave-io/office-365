<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class OrderSummaryResponse
{
    private RequestStatus $status;

    private PagedResultOfOrderSummary $pagedResult;

    public function getStatus(): RequestStatus
    {
        return $this->status;
    }

    public function getPagedResult(): PagedResultOfOrderSummary
    {
        return $this->pagedResult;
    }
}
