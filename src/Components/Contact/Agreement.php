<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components\Contact;

use SandwaveIo\Office365\Components\AbstractComponent;
use SandwaveIo\Office365\Entity\AgreementContact;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Transformer\AgreementContactDataTransformer;

final class Agreement extends AbstractComponent
{
    /**
     * @throws Office365Exception
     */
    public function create(
        string $firstname,
        string $lastname,
        string $email,
        string $phoneNumber,
        \DateTime $agreed
    ): AgreementContact {
        $agreementContact = EntityHelper::deserialize(AgreementContact::class, AgreementContactDataTransformer::transform(...func_get_args()));

        if ($agreementContact === null) {
            throw new Office365Exception(self::class . ':create Tenant could not be created');
        }

        return $agreementContact;
    }
}
