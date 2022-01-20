<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class AddonDataBuilder
{
    /**
     * @return array<string, int|string>
     */
    public static function build(
        int $parentOrderId,
        string $productCode,
        int $quantity
    ): array {
        return [
            'ParentOrderId' => $parentOrderId,
            'ProductCode' => $productCode,
            'Quantity' => $quantity,
        ];
    }
}
