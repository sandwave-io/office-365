<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class QueuedResponse
{
    private bool $success;

    private int $errorCode;

    private ?string $errorMessage = null;

    public function __construct(bool $success, int $errorCode, ?string $errorMessage = null)
    {
        $this->success = $success;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}
