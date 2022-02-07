<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

abstract class AbstractRealtimeResponse
{
    private RequestStatus $status;

    final public function setStatus(RequestStatus $status): void
    {
        $this->status = $status;
    }

    final public function getStatus(): RequestStatus
    {
        return $this->status;
    }
}
