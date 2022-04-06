<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class Error implements EntityInterface
{
    /**
     * @var array<string>
     */
    private array $messages;

    /**
     * @var \SimpleXMLElement
     */
    private \SimpleXMLElement $originalXml;

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

    /**
     * @return \SimpleXMLElement $xml
     */
    public function getOriginalXml(): \SimpleXMLElement
    {
        return $this->originalXml;
    }

    /**
     * @param \SimpleXMLElement $xml
     */
    public function setOriginalXml(\SimpleXMLElement $xml): void
    {
        $this->originalXml = $xml;
    }
}
