<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Config;

final class YamlConfig
{
    /**
     * @var array<string, array<string>>
     */
    private array $yaml;

    /**
     *
     * @param array<string, array<string>> $yaml
     */
    public function __construct(array $yaml)
    {
        $this->yaml = $yaml;
    }

    public function getClassName(): ?string
    {
        return array_key_first($this->yaml);
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
