<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use SandwaveIo\Office365\Entity\Header\CustomerHeader;

final class Customer implements EntityInterface
{
    private ?CustomerHeader $header = null;

    private string $name;

    private string $street;

    private int $houseNr;

    private ?string $houseNrExtension = null;

    private string $zipCode;

    private string $city;

    private string $countryCode;

    private string $phone1;

    private ?string $phone2 = null;

    private ?string $fax = null;

    private string $email;

    private ?string $website = null;

    private ?string $debitNr = null;

    private ?string $iban = null;

    private ?string $bic = null;

    private string $legalStatus;

    private ?string $externalId = null;

    private ?string $chamberOfCommerceNr = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouseNr(): int
    {
        return $this->houseNr;
    }

    public function getHouseNrExtension(): ?string
    {
        return $this->houseNrExtension;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getPhone1(): string
    {
        return $this->phone1;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function getDebitNr(): ?string
    {
        return $this->debitNr;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function getLegalStatus(): string
    {
        return $this->legalStatus;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getChamberOfCommerceNr(): ?string
    {
        return $this->chamberOfCommerceNr;
    }

    public function getHeader(): ?CustomerHeader
    {
        return $this->header;
    }
}
