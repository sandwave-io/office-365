<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity\CloudAgreementContact_V1;

final class CloudAgreementContact_V1
{
    private string $firstName;

    private string $lastName;

    private string $emailAddress;

    private string $phoneNumber;

    private \DateTime $dateAgreed;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function getPhoneNumber(): string
    {
        return $this->firstName;
    }

    public function getDateAgreed(): \DateTime
    {
        return $this->dateAgreed;
    }
}
