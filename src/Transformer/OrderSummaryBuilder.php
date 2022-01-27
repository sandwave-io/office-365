<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class OrderSummaryBuilder
{
    /**
     * @return array<string, mixed>
     */
    public static function build(
        int $customerId,
        string $orderState,
        string $productGroup,
        \DateTime $dateActiveFrom,
        \DateTime $dateActiveTo,
        \DateTime $dateModifiedFrom,
        \DateTime $dateModifiedTo,
        string $label,
        string $attribute,
        int $skip,
        int $take
    ): array {
        return [
            'CustomerId' => $customerId,
            'OrderState' => $orderState,
            'ProductGroup' => $productGroup,
            'DateActiveFrom' => $dateActiveFrom,
            'DateActiveTo' => $dateActiveTo,
            'DateModifiedFrom' => $dateModifiedFrom,
            'DateModifiedTo' => $dateModifiedTo,
            'Label' => $label,
            'Attribute' => $attribute,
            'Skip' => $skip,
            'Take' => $take,
        ];
    }
}
