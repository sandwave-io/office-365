<?php declare(strict_types = 1);

namespace Integration\Webhook;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Helper\EntityHelper;

final class CustomerTest extends TestCase
{
    /**
     * @test
     */
    public function incomingCustomer(): void
    {
        /** @var Customer $customer */
        $customer = EntityHelper::createFromXML(
            (string) file_get_contents(__DIR__ . '/../Data/Request/NewCustomerRequest.xml')
        );

        Assert::assertInstanceOf(Customer::class, $customer);
        Assert::assertSame('Naam Klant', $customer->getName());
        Assert::assertSame('StraatNaam', $customer->getStreet());
        Assert::assertSame(38, $customer->getHouseNr());
        Assert::assertSame('', $customer->getHouseNrExtension());
        Assert::assertSame('1234AB', $customer->getZipCode());
        Assert::assertSame('Amsterdam', $customer->getCity());
        Assert::assertSame('NLD', $customer->getCountryCode());
        Assert::assertSame('0612345678', $customer->getPhone1());
        Assert::assertSame(null, $customer->getPhone2());
        Assert::assertSame(null, $customer->getFax());
        Assert::assertSame('klant@email.nl', $customer->getEmail());
        Assert::assertSame('', $customer->getWebsite());
        Assert::assertSame('', $customer->getDebitNr());
        Assert::assertSame(null, $customer->getIban());
        Assert::assertSame(null, $customer->getBic());
        Assert::assertSame('CV', $customer->getLegalStatus());
        Assert::assertSame(null, $customer->getExternalId());
        Assert::assertSame(null, $customer->getChamberOfCommerceNr());
    }
}
