<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Helper\EntityHelper;

final class CustomerTest extends TestCase
{
    /**
     * @test
     */
    public function incomingCustomer(): void
    {
        $incomingCustomerXml = (string) file_get_contents(__DIR__ . '/../Data/Webhook/Customer.xml');

        /** @var Customer $customer */
        $customer = EntityHelper::createFromXML($incomingCustomerXml, RequestAction::NEW_CUSTOMER_REQUEST_V1);
        Assert::assertInstanceOf(Customer::class, $customer);
        Assert::assertSame($customer->getName(), 'Naam Klant');
        Assert::assertSame($customer->getStreet(), 'StraatNaam');
        Assert::assertSame($customer->getHouseNr(), 38);
        Assert::assertSame($customer->getHouseNrExtension(), '');
        Assert::assertSame($customer->getZipCode(), '1234AB');
        Assert::assertSame($customer->getCity(), 'Amsterdam');
        Assert::assertSame($customer->getCountryCode(), 'NLD');
        Assert::assertSame($customer->getPhone1(), '0612345678');
        Assert::assertSame($customer->getPhone2(), null);
        Assert::assertSame($customer->getFax(), null);
        Assert::assertSame($customer->getEmail(), 'klant@email.nl');
        Assert::assertSame($customer->getWebsite(), '');
        Assert::assertSame($customer->getDebitNr(), '');
        Assert::assertSame($customer->getIban(), null);
        Assert::assertSame($customer->getBic(), null);
        Assert::assertSame($customer->getLegalStatus(), 'CV');
        Assert::assertSame($customer->getExternalId(), null);
        Assert::assertSame($customer->getChamberOfCommerceNr(), null);
    }
}
