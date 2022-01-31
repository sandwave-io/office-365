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
            'DateActiveFrom' => $dateActiveFrom === null ? null : $dateActiveFrom->format('Y-m-d'),
            'DateActiveTo' => $dateActiveTo === null ? null : $dateActiveTo->format('Y-m-d'),
            'DateModifiedFrom' => $dateModifiedFrom === null ? null : $dateModifiedFrom->format('Y-m-d'),
            'DateModifiedTo' => $dateModifiedTo === null ? null : $dateModifiedTo->format('Y-m-d'),
            'Label' => $label,
            'Attribute' => $attribute,
            'Skip' => $skip,
            'Take' => $take,
        ];
    }
}
