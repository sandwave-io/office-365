<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerObserverInterface;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Transformer\CustomerResponseXmlTransformer;

final class CustomerTest extends TestCase
{
    /** @test **/
    public function create(): void
    {
        /** @var Customer $customer */
        $customer = EntityHelper::createFromXML(
            (string) file_get_contents(__DIR__ . '/../Data/Response/CreateCustomer.xml'),
            new CustomerResponseXmlTransformer()
        );

        Assert::assertInstanceOf(Customer::class, $customer);
        Assert::assertSame($customer->getName(), 'Naam Klant');
        Assert::assertSame($customer->getStreet(), 'StraatNaam');
        Assert::assertSame($customer->getHouseNr(), 38);
        Assert::assertSame($customer->getHouseNrExtension(), null);
        Assert::assertSame($customer->getZipCode(), '1234AB');
        Assert::assertSame($customer->getCity(), 'Amsterdam');
        Assert::assertSame($customer->getCountryCode(), 'NLD');
        Assert::assertSame($customer->getPhone1(), '0612345678');
        Assert::assertSame($customer->getPhone2(), null);
        Assert::assertSame($customer->getFax(), null);
        Assert::assertSame($customer->getEmail(), 'klant@email.nl');
        Assert::assertSame($customer->getWebsite(), null);
        Assert::assertSame($customer->getDebitNr(), null);
        Assert::assertSame($customer->getIban(), null);
        Assert::assertSame($customer->getBic(), null);
        Assert::assertSame($customer->getVatNr(), null);
        Assert::assertSame($customer->getLegalStatus(), 'CV');
        Assert::assertSame($customer->getExternalId(), null);
        Assert::assertSame($customer->getChamberOfCommerceNr(), null);
        Assert::assertSame($customer->getCustomerId(), 'CID1322912');
    }

    /** @test **/
    public function modify(): void
    {
        /** @var Customer $customer */
        $customer = EntityHelper::createFromXML(
            (string) file_get_contents(__DIR__ . '/../Data/Response/ModifyCustomer.xml'),
            new CustomerResponseXmlTransformer()
        );

        Assert::assertInstanceOf(Customer::class, $customer);
        Assert::assertSame($customer->getName(), 'Naam Klant');
        Assert::assertSame($customer->getStreet(), 'StraatNaam');
        Assert::assertSame($customer->getHouseNr(), 38);
        Assert::assertSame($customer->getHouseNrExtension(), null);
        Assert::assertSame($customer->getZipCode(), '1234AB');
        Assert::assertSame($customer->getCity(), 'Amsterdam');
        Assert::assertSame($customer->getCountryCode(), 'NLD');
        Assert::assertSame($customer->getPhone1(), '0612345678');
        Assert::assertSame($customer->getPhone2(), null);
        Assert::assertSame($customer->getFax(), null);
        Assert::assertSame($customer->getEmail(), 'klant@email.nl');
        Assert::assertSame($customer->getWebsite(), null);
        Assert::assertSame($customer->getDebitNr(), null);
        Assert::assertSame($customer->getIban(), null);
        Assert::assertSame($customer->getBic(), null);
        Assert::assertSame($customer->getVatNr(), null);
        Assert::assertSame($customer->getLegalStatus(), 'CV');
        Assert::assertSame($customer->getExternalId(), null);
        Assert::assertSame($customer->getChamberOfCommerceNr(), null);
        Assert::assertSame($customer->getCustomerId(), 'CID1322912');
    }

    /** @test **/
    public function callbackWebhook(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/CreateCustomer.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CUSTOMER_CREATE, new class() implements CustomerObserverInterface {
            public function execute(Customer $customer): void
            {
                Assert::assertSame($customer->getName(), 'Naam Klant');
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/CreateCustomer.xml')
        );
    }
}
