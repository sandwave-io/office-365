<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use DateTime;

final class TerminateDataBuilder
{
    /**
     * @return array<string, string|bool|DateTime>
     */
    public static function build(
        string $orderId,
        DateTime $desiredTerminateDate,
        bool $terminateAsSoonAsPossible
    ): array {
        return [
            'OrderId' => $orderId,
            'DesiredTerminateDate' => $desiredTerminateDate,
            'TerminateAsSoonAsPossible' => $terminateAsSoonAsPossible,
        ];
    }
}
