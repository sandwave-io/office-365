<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Response;

class QueuedResponse
{
    private bool $success;

    private string $errorMessage;

    private int $errorCode;

    public function __construct(bool $success, string $errorMessage, int $errorCode)
    {
        $this->success = $success;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}
