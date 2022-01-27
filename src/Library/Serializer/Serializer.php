<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Serializer;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Transformer\TransformerInterface;
use Symfony\Component\Yaml\Yaml;

final class Serializer
{
    /**
     * @var array<Meta>
     */
    private array $meta = [];

    private SerializerInterface $serializer;

    public function __construct()
    {
        $this->meta['entity'] = new Meta(__DIR__ . '/../../../config/serializer', 'SandwaveIo\Office365\Entity');
        $this->meta['response'] = new Meta(__DIR__ . '/../../../config/serializer/response', 'SandwaveIo\Office365\Response');
        $this->meta['header'] = new Meta(__DIR__ . '/../../../config/serializer/header', 'SandwaveIo\Office365\Entity\Header');

        $this->serializer = SerializerBuilder::create()
            ->addMetadataDir($this->meta['entity']->dir, $this->meta['entity']->prefix)
            ->addMetadataDir($this->meta['response']->dir, $this->meta['response']->prefix)
            ->addMetadataDir($this->meta['header']->dir, $this->meta['header']->prefix)
            ->build();
    }

    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    public function getRootNode(string $class): string
    {
        $name = explode('\\', $class);
        $meta = Yaml::parseFile($this->meta['entity']->dir . '/' . end($name) . '.yaml');

        if (! array_key_exists('xml_root_name', $meta[array_key_first($meta)])) {
            throw new Office365Exception('XML root name does not exist in ' . end($name));
        }

        return $meta[array_key_first($meta)]['xml_root_name'];
    }

    /** @return array<mixed>|null */
    public function findConfigByRootname(string $rootNode): ?array
    {
        $configDirectory = opendir($this->meta['entity']->dir);

        if ($configDirectory !== false) {
            while (false !== ($entry = readdir($configDirectory))) {
                $file = $this->meta['entity']->dir . '/' . $entry;

                if (is_file($file)) {
                    $meta = Yaml::parseFile($file);
                    $className = array_key_first($meta);

                    if (array_key_exists('xml_root_name', $meta[$className]) && $rootNode === $meta[$className]['xml_root_name']) {
                        return $meta;
                    }
                }
            }
        }

        return null;
    }

    /**
     * @param array<string, mixed> $config
     *
     * @return string|null
     */
    public function findClassByConfig(array $config): ?string
    {
        $className = array_key_first($config);

        if (array_key_exists('xml_root_name', $config[$className])) {
            return $className;
        }

        return null;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function findResponseTransformerByConfig(array $config): ?TransformerInterface
    {
        $className = array_key_first($config);

        if (array_key_exists('transformer', $config[$className]) && array_key_exists('response', $config[$className]['transformer'])) {
            return new $config[$className]['transformer']['response']();
        }

        return null;
    }
}
