<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Library\Config;

class YamlConfig
{
    /**
     * @var array<array>
     */
    private array $yaml;

    /**
     * YamlConfig constructor.
     * @param array<array> $yaml
     */
    public function __construct(array $yaml)
    {
        $this->yaml = $yaml;
    }

    public function getClassName(): ?string
    {
        $className = array_key_first($this->yaml);

        if ($className !== null) {
            return (string) $className;
        }
        return null;
    }

    public function getReferenceNode(): ?string
    {
        $className = array_key_first($this->yaml);

        if (array_key_exists('xml_data_node', $this->yaml[$className])) {
            return $this->yaml[$className]['xml_data_node'];
        }

        return null;
    }
}
