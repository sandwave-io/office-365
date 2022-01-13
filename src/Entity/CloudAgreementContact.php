<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\CustomerHeader;
use SandwaveIo\Office365\Entity\CloudAgreementContact_V1\AgreementContact;

final class CloudAgreementContact implements EntityInterface
{
    private ?CustomerHeader $header = null;

    private int $customerId;

    private AgreementContact $cloudAgreementContact;

    public function getHeader(): ?CustomerHeader
    {
        return $this->header;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getCloudAgreementContact(): AgreementContact
    {
        return $this->cloudAgreementContact;
    }
}
