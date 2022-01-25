<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use DateTime;

final class TerminateDataBuilder
{
    /**
     * @return array<string, string|mixed>
     */
    public static function build(
        string $orderId,
        DateTime $desiredTerminateDate,
        bool $terminateAsSoonAsPossible,
        string $partnerReference = ''
    ): array {
        return [
            'OrderId' => $orderId,
            'DesiredTerminateDate' => $desiredTerminateDate->format('Y-m-d'),
            'TerminateAsSoonAsPossible' => $terminateAsSoonAsPossible,
            'Header' => $partnerReference !== '' ? [
                'PartnerReference' => $partnerReference,
                'DateCreated' => (new \DateTime())->format('Y-m-d\TH:i:s'),
            ] : null,
        ];
    }
}
