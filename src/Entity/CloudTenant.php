<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

final class CloudTenant implements EntityInterface
{
    private ?string $tenantId = null;

    private ?string $status = null;

    private string $name;

    private string $firstname;

    private string $lastname;

    private string $email;

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getName(): string
    {
        return $this->name;
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
}
