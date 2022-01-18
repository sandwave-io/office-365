<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Enum;

final class RequestAction
{
    const NEW_CUSTOMER_REQUEST_V1 = 'NewCustomerRequest_V1';

    const NEW_CLOUD_LICENSE_ORDER_REQUEST_V2 = 'NewCloudLicenseOrderRequest_V2';

    const CLOUD_TENANT_REQUEST_V1 = 'CloudTenantRequest_V1';

    public static function reverseLookUp(string $className): string
    {

    }
}
