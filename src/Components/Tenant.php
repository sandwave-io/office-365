<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use DOMException;
use SandwaveIo\Office365\Entity\CloudTenant;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Transformer\TenantDataTransformer;

final class Tenant extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function create(string $name, string $firstname, string $lastname, string $email): CloudTenant
    {
        $tenant = EntityHelper::deserialize(CloudTenant::class, TenantDataTransformer::transform(...func_get_args()));

        if ($tenant === null) {
            throw new Office365Exception("Tenant could not be created");
        }

        return $tenant;
    }
}
