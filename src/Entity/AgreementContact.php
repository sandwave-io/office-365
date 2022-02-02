<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class AgreementContact implements EntityInterface
{
    private ?string $status = null;

    private string $firstname;

    private string $lastname;

    private string $email;

    private string $phoneNumber;

    private \DateTime $agreed;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $phoneNumber,
        \DateTime $agreed
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->agreed = $agreed;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getFirstName(): string
    {
        return $this->firstname;
    }

    public function getLastName(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getAgreed(): string
    {
        return $this->agreed->format('Y-m-d');
    }
}
