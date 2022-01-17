<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Enum\RequestAction;

final class TenantDomainOwnershipResponseTransformer
{
    public static function transform(\SimpleXMLElement $response): array
    {
        return [
            'Status' => $response->Status,
            'IsDelegatedAccessAllowed' => $response->IsDelegatedAccessAllowed,
            'IsAcceptanceMcaRequired' => $response->IsAcceptanceMcaRequired,
            'IsOnboardingReady' => $response->IsOnboardingReady,
            'DnsBoardingRecordName' => $response->DnsBoardingRecordName,
            'DnsBoardingRecordValue' => $response->DnsBoardingRecordValue,
        ];
    }
}
