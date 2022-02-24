<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class QueuedResponse
{
    private bool $success;

    private int $errorCode;

    private ?string $errorMessage = null;

    /**
     * @var array<int, string>
     */
    private array $errorDetails = [];

    /**
     * @param bool               $success
     * @param int                $errorCode
     * @param string|null        $errorMessage
     * @param array<int, string> $errorDetails
     */
    public function __construct(bool $success, int $errorCode, ?string $errorMessage = null, array $errorDetails = [])
    {
        $this->success = $success;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
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

    /**
     * @return array<int, string>
     */
    public function getErrorDetails(): array
    {
        return $this->errorDetails;
    }
}
