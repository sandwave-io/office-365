<?php declare(strict_types=1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\CustomerHeader;
use SandwaveIo\Office365\Entity\CloudAgreementContact_V1\CloudAgreementContact_V1;

final class CloudAgreementContact implements EntityInterface
{
    private ?CustomerHeader $header = null;

    private int $customerId;

    private CloudAgreementContact_V1 $cloudAgreementContact;

    public function getHeader(): ?CustomerHeader
    {
        return $this->header;
    }

    public function getCloudAgreementContract(): CloudAgreementContact_V1
    {
        return $this->cloudAgreementContact;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }
}
