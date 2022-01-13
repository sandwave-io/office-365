<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class RequestStatus
{
    /** @var string[] */
    public ?array $messages;

    public string $code;

    /**
     * @param string[] $messages
     * @param string   $code
     */
    public function __construct(string $code, array $messages = [])
    {
        $this->messages = $messages;
        $this->code = $code;
    }
}
