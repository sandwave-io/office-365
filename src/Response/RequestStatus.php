<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Response;

final class RequestStatus
{
    /** @var string[] */
    private array $messages;

    private string $code;

    /**
     * @param string[] $messages
     * @param string   $code
     */
    public function __construct(array $messages, string $code)
    {
        $this->messages = $messages;
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
