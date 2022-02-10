<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;

final class Terminate implements EntityInterface
{
    private ?PartnerReferenceHeader $header = null;

    private string $orderId;

    private \DateTime $desiredTerminateDate;

    private bool $terminateAsSoonAsPossible;

    public function __construct(string $orderId, \DateTime $desiredTerminateDate, bool $terminateAsSoonAsPossible)
    {
        $this->orderId = $orderId;
        $this->desiredTerminateDate = $desiredTerminateDate;
        $this->terminateAsSoonAsPossible = $terminateAsSoonAsPossible;
    }

    public function getHeader(): ?PartnerReferenceHeader
    {
        return $this->header;
    }

    public function setHeader(PartnerReferenceHeader $header): void
    {
        $this->header = $header;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getDesiredTerminateDate(): \DateTime
    {
        return $this->desiredTerminateDate;
    }

    public function getTerminateAsSoonAsPossible(): bool
    {
        return $this->terminateAsSoonAsPossible;
    }
}
