<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class QueuedResponse
{
    private bool $success;

    private ?string $errorMessage;

    private int $errorCode;

    /** @var string[]|null */
    private ?array $errorDetails;

    /** @param string[]|null $errorDetails */
    public function __construct(bool $success, int $errorCode, ?string $errorMessage, ?array $errorDetails)
    {
        $this->success = $success;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
        $this->errorDetails = $errorDetails;
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

    /** @return string[]|null  */
    public function getErrorDetails(): ?array
    {
        return $this->errorDetails;
    }
}
