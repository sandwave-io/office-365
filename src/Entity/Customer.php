<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Entity;

use JMS\Serializer\Annotation as Serializer;
use SandwaveIo\Office365\Entity\Header\CustomerHeader;

final class Customer implements EntityInterface
{

    private ?CustomerHeader $header = null;

    /**
     * @Serializer\SerializedName("Name")
     * @Serializer\Type("string")
     */
    private string $name;

    /**
     * @Serializer\SerializedName("Street")
     * @Serializer\Type("string")
     */
    private string $street;

    /**
     * @Serializer\SerializedName("HouseNr")
     * @Serializer\Type("int")
     */
    private int $houseNr;

    /**
     * @Serializer\SerializedName("HouseNrExtension")
     * @Serializer\Type("string")
     */
    private ?string $houseNrExtension = null;

    /**
     * @Serializer\SerializedName("ZipCode")
     * @Serializer\Type("string")
     */
    private string $zipCode;

    /**
     * @Serializer\SerializedName("City")
     * @Serializer\Type("string")
     */
    private string $city;

    /**
     * @Serializer\SerializedName("CountryCode")
     * @Serializer\Type("string")
     */
    private string $countryCode;

    /**
     * @Serializer\SerializedName("Phone1")
     * @Serializer\Type("string")
     */
    private string $phone1;

    /**
     * @Serializer\SerializedName("Phone2")
     * @Serializer\Type("string")
     */
    private ?string $phone2 = null;

    /**
     * @Serializer\SerializedName("Fax")
     * @Serializer\Type("string")
     */
    private ?string $fax = null;

    /**
     * @Serializer\SerializedName("Email")
     * @Serializer\Type("string")
     */
    private string $email;

    /**
     * @Serializer\SerializedName("Website")
     * @Serializer\Type("string")
     */
    private ?string $website = null;

    /**
     * @Serializer\SerializedName("DebitNr")
     * @Serializer\Type("string")
     */
    private ?string $debitNr = null;

    /**
     * @Serializer\SerializedName("IBAN")
     * @Serializer\Type("string")
     */
    private ?string $iban = null;

    /**
     * @Serializer\SerializedName("BIC")
     * @Serializer\Type("string")
     */
    private ?string $bic = null;

    /**
     * @Serializer\SerializedName("LegalStatus")
     * @Serializer\Type("string")
     */
    private string $legalStatus;

    /**
     * @Serializer\SerializedName("ExternalId")
     * @Serializer\Type("string")
     */
    private ?string $externalId = null;

    /**
     * @Serializer\SerializedName("ChamberOfCommerceNr")
     * @Serializer\Type("string")
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
