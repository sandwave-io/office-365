<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Entity\Error;
use SandwaveIo\Office365\Entity\Terminate;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Error\ErrorObserverInterface;
use SandwaveIo\Office365\Library\Observer\Terminate\TerminateObserverInterface;
use SandwaveIo\Office365\Office\OfficeClient;

final class CustomerTest extends TestCase
{
    /**
     * @test
     */
    public function incomingCustomerCreate(): void
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

    /**
     * @test
     */
    public function callbackCustomerCreate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/TerminateRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::TERMINATE_ORDER, new class() implements TerminateObserverInterface {
            public function execute(Terminate $terminate): void
            {
                Assert::assertSame('OID330', $terminate->getOrderId());
                Assert::assertTrue($terminate->getTerminateAsSoonAsPossible());
                Assert::assertSame('2014-06-20', $terminate->getDesiredTerminateDate()->format('Y-m-d'));

                if ($terminate->getHeader() !== null) {
                    Assert::assertSame('21139', $terminate->getHeader()->getPartnerReference());
                }
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Request/TerminateRequest.xml')
        );
    }

    /**
     * @test
     */
    public function callbackCustomerCreateDeclined(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/NewCustomerRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CALLBACK_ERROR, new class() implements ErrorObserverInterface {
            public function execute(Error $error): void
            {
                Assert::assertEquals(1, count($error->getMessages()));
                Assert::assertEquals('Onverwachte fout tijdens het aanmaken van de gebruiker.', $error->getMessages()[0]);
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/NewCustomerDeclined.xml')
        );
    }
//
//    /**
//     * @test
//     */
//    public function callbackCustomerModify(): void
//    {
//        $mockHandler = new MockHandler(
//            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/ModifyCustomerRequest.xml'))]
//        );
//
//        $stack = HandlerStack::create($mockHandler);
//        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);
//
//        $client->webhook->addEventSubscriber(Event::TERMINATE_ORDER, new class() implements TerminateObserverInterface {
//            public function execute(Terminate $terminate): void
//            {
//                Assert::assertSame('OID330', $terminate->getOrderId());
//                Assert::assertTrue($terminate->getTerminateAsSoonAsPossible());
//                Assert::assertSame('2014-06-20', $terminate->getDesiredTerminateDate()->format('Y-m-d'));
//
//                if ($terminate->getHeader() !== null) {
//                    Assert::assertSame('21139', $terminate->getHeader()->getPartnerReference());
//                }
//            }
//        });
//
//        $client->webhook->process(
//            (string) file_get_contents(__DIR__ . '/../Data/Response/ModifyCustomerSuccess.xml')
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function callbackCustomerModifyDeclined(): void
//    {
//        $mockHandler = new MockHandler(
//            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/ModifyCustomerRequest.xml'))]
//        );
//
//        $stack = HandlerStack::create($mockHandler);
//        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);
//
//        $client->webhook->addEventSubscriber(Event::CALLBACK_ERROR, new class() implements ErrorObserverInterface {
//            public function execute(Error $error): void
//            {
//                Assert::assertSame(1, count($error->getMessages()));
//                Assert::assertEquals('Email: E-mailadres is ongeldig. Vul een geldig e-mailadres in.', $error->getMessages()[0]);
//            }
//        });
//
//        $client->webhook->process(
//            (string) file_get_contents(__DIR__ . '/../Data/Response/ModifyCustomerDeclined.xml')
//        );
//    }
}
