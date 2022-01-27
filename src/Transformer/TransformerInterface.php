<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Transformer;

interface TransformerInterface
{
    public function transform(string $xml): string;
}
