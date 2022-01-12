<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use JMS\Serializer\Annotation as Test;
use SandwaveIo\Office365\Entity\Header\CustomerHeader;

final class Customer implements EntityInterface
{
    private ?CustomerHeader $header = null;

    /**
     * @Test\SerializedName("Name")
     * @Test\Type("string")
     */
    private string $name;

    /**
     * @Test\SerializedName("Street")
     * @Test\Type("string")
     */
    private string $street;

    /**
     * @Test\SerializedName("HouseNr")
     * @Test\Type("int")
     */
    private int $houseNr;

    /**
     * @Test\SerializedName("HouseNrExtension")
     * @Test\Type("string")
     */
    private ?string $houseNrExtension = null;

    /**
     * @Test\SerializedName("ZipCode")
     * @Test\Type("string")
     */
    private string $zipCode;

    /**
     * @Test\SerializedName("City")
     * @Test\Type("string")
     */
    private string $city;

    /**
     * @Test\SerializedName("CountryCode")
     * @Test\Type("string")
     */
    private string $countryCode;

    /**
     * @Test\SerializedName("Phone1")
     * @Test\Type("string")
     */
    private string $phone1;

    /**
     * @Test\SerializedName("Phone2")
     * @Test\Type("string")
     */
    private ?string $phone2 = null;

    /**
     * @Test\SerializedName("Fax")
     * @Test\Type("string")
     */
    private ?string $fax = null;

    /**
     * @Test\SerializedName("Email")
     * @Test\Type("string")
     */
    private string $email;

    /**
     * @Test\SerializedName("Website")
     * @Test\Type("string")
     */
    private ?string $website = null;

    /**
     * @Test\SerializedName("DebitNr")
     * @Test\Type("string")
     */
    private ?string $debitNr = null;

    /**
     * @Test\SerializedName("IBAN")
     * @Test\Type("string")
     */
    private ?string $iban = null;

    /**
     * @Test\SerializedName("BIC")
     * @Test\Type("string")
     */
    private ?string $bic = null;

    /**
     * @Test\SerializedName("LegalStatus")
     * @Test\Type("string")
     */
    private string $legalStatus;

    /**
     * @Test\SerializedName("ExternalId")
     * @Test\Type("string")
     */
    private ?string $externalId = null;

    /**
     * @Test\SerializedName("ChamberOfCommerceNr")
     * @Test\Type("string")
     * 
     */
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
