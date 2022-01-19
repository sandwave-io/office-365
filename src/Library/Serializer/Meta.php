<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Library\Serializer;

final class Meta
{
    public string $dir;

    public string $prefix;

    public function __construct(string $dir, string $prefix)
    {
        $this->dir = $dir;
        $this->prefix = $prefix;
    }
}
