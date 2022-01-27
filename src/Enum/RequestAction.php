<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Enum;

final class RequestAction
{
    const NEW_CUSTOMER_REQUEST_V1 = 'NewCustomerRequest_V1';

    const NEW_CUSTOMER_RESPONSE_V3 = 'NewCustomerResponse_V3';

    const NEW_CLOUD_LICENSE_ORDER_REQUEST_V2 = 'NewCloudLicenseOrderRequest_V2';

    const NEW_CLOUD_AGREEMENT_CONTACT_REQUEST_V1 = 'NewCloudAgreementContactRequest_V1';

    const NEW_CLOUD_LICENSE_ADDON_ORDER_REQUEST_V1 = 'NewCloudLicenseAddOnOrderRequest_V1';

    const TERMINATE_ORDER_REQUEST_V2 = 'TerminateOrderRequest_V2';

    const MODIFY_ORDER_QUANTITY_REQUEST_V1 = 'ModifyOrderQuantityRequest_V1';
}
