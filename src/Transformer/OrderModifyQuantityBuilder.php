<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Components\Order\Order;

final class OrderModifyQuantityBuilder
{
    /**
     * @return array<string, mixed>
     */
    public static function build(
        int $orderId,
        int $quantity,
        bool $delta = false,
        string $partnerReference = ''
    ): array {
        return [
            'OrderId' => $orderId,
            'Quantity' => $quantity,
            'IsDelta' => $delta ? 1 : 0,
            'Header' => $partnerReference !== '' ? [
                'PartnerReference' => $partnerReference,
                'DateCreated' => (new \DateTime())->format('Y-m-d\TH:i:s'),
            ] : null,
        ];
    }
}
