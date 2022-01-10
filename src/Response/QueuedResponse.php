<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Response;

class QueuedResponse
{
    private bool $success;

    private string $errorMessage;

    public function __construct(bool $success, string $errorMessage)
    {
        $this->success = $success;
        $this->errorMessage = $errorMessage;
    }
}
