<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use DateTime;

final class OrderSummaryBuilder
{
    /**
     * @return array<string, mixed>
     */
    public static function build(
        ?int $customerId,
        ?string $orderState,
        ?string $productGroup,
        string $productName,
        ?DateTime $dateActiveFrom,
        ?DateTime $dateActiveTo,
        ?DateTime $dateModifiedFrom,
        ?DateTime $dateModifiedTo,
        ?string $label,
        ?string $attribute,
        ?int $skip,
        ?int $take
    ): array {
        return [
            'CustomerId' => $customerId,
            'OrderState' => $orderState,
            'ProductGroup' => $productGroup,
            'ProductName' => $productName,
            'DateActiveFrom' => $dateActiveFrom === null ? null : $dateActiveFrom->format('Y-m-d\TH:i:s'),
            'DateActiveTo' => $dateActiveTo === null ? null : $dateActiveTo->format('Y-m-d\TH:i:s'),
            'DateModifiedFrom' => $dateModifiedFrom === null ? null : $dateModifiedFrom->format('Y-m-d\TH:i:s'),
            'DateModifiedTo' => $dateModifiedTo === null ? null : $dateModifiedTo->format('Y-m-d\TH:i:s'),
            'Label' => $label,
            'Attribute' => $attribute,
            'Skip' => $skip,
            'Take' => $take,
        ];
    }
}
