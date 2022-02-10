<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

use SandwaveIo\Office365\Entity\PagedResult;

final class OrderSummaryResponse
{
    private RequestStatus $status;

    private PagedResult $pagedResult;

    public function getStatus(): RequestStatus
    {
        return $this->status;
    }

    public function getPagedResult(): PagedResult
    {
        return $this->pagedResult;
    }
}
