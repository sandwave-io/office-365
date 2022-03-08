<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Status;

final class Status
{
    private string $statusCode;

    /**
     * @var array<string>
     */
    private array $messages;

    /**
     * @param array<string> $messages
     */
    public function __construct(string $statusCode, array $messages)
    {
        $this->statusCode = $statusCode;
        $this->messages = $messages;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * @return array<string>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
