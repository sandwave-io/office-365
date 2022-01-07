<?php declare(strict_types=1);

namespace Office365\Transformer;

use Office365\Helper\DateHelper;
use Office365\Helper\ParameterHelper;

class ArrayToCustomer
{
    public static function transform(string $name): array
    {
        return [
            'Header' => [
                'PartnerReference' => ParameterHelper::get('kpn')['partner_reference'],
                'DateCreated' => DateHelper::UTC()->format('Y-m-d\TH:i:s')
            ],
            'Name' => 'test',
        ];

    }
}
