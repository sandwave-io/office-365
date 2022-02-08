<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class Error implements EntityInterface
{
    /**
     * @var array<string>
     */
    private array $messages;

    /**
     * @return array<string>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array<string> $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }
}
