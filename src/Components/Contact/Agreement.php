<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components\Contact;

use DOMException;
use SandwaveIo\Office365\Components\AbstractComponent;
use SandwaveIo\Office365\Entity\AgreementContact;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Transformer\AgreementContactDataTransformer;

final class Agreement extends AbstractComponent
{
    /**
     * @throws DOMException
     * @throws Office365Exception
     */
    public function create(string $name, string $firstname, string $lastname, string $email, \DateTime $agreed): AgreementContact
    {
        $tenant = EntityHelper::deserialize(AgreementContact::class, AgreementContactDataTransformer::transform(...func_get_args()));

        if ($tenant === null) {
            throw new Office365Exception("Tenant could not be created");
        }

        return $tenant;
    }
}