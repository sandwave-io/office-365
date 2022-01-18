<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class TenantDomainOwnershipResponseTransformer
{
    /**
     * @return array<string, int|string|\SimpleXMLElement>
     */
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
