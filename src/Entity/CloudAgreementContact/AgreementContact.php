<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity\CloudAgreementContact;

final class AgreementContact
{
    private string $firstName;

    private string $lastName;

    private string $emailAddress;

    private string $phoneNumber;

    private \DateTime $dateAgreed;

    public function __construct(string $firstName, string $lastName, string $emailAddress, string $phoneNumber, \DateTime $dateAgreed)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->emailAddress = $emailAddress;
        $this->phoneNumber = $phoneNumber;
        $this->dateAgreed = $dateAgreed;
    }

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
        return $this->phoneNumber;
    }

    public function getDateAgreed(): \DateTime
    {
        return $this->dateAgreed;
    }
}
