<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class AgreementContact implements EntityInterface
{
    private ?string $status = null;

    private string $firstname;

    private string $lastname;

    private string $email;

    private \DateTime $agreed;

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

    public function getAgreed(): \DateTime
    {
        return $this->agreed;
    }
}
