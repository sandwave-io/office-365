<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Library\Serializer\Serializer;

final class ClassTransformer
{
    public static function transform(string $rootNode): string
    {
        $serializer = new Serializer();
        $config = $serializer->findConfigByRootname($rootNode);

        if ($config === null) {
            return '';
        }

        return $serializer->findClassByConfig($config) ?? '';
    }
}
