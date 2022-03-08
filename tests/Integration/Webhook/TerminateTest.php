<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Error;
use SandwaveIo\Office365\Entity\Terminate;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Error\ErrorObserverInterface;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SandwaveIo\Office365\Library\Observer\Terminate\TerminateObserverInterface;
use SandwaveIo\Office365\Office\OfficeClient;

final class TerminateTest extends TestCase
{
    /**
     * @test
     */
    public function incomingTerminate(): void
    {
        /** @var Terminate $terminate */
        $terminate = EntityHelper::createFromXML(
            (string) file_get_contents(__DIR__ . '/../Data/Request/TerminateRequest.xml')
        );

        Assert::assertInstanceOf(Terminate::class, $terminate);
        Assert::assertSame('OID330', $terminate->getOrderId());
        Assert::assertSame('2014-06-20', $terminate->getDesiredTerminateDate()->format('Y-m-d'));
        Assert::assertTrue($terminate->getTerminateAsSoonAsPossible());
    }

    /**
     * @test
     */
    public function callbackTerminateSuccess(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/TerminateRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::TERMINATE_ORDER, new class() implements TerminateObserverInterface {
            public function execute(Terminate $terminate, Status $status): void
            {
                Assert::assertSame('13608704', $terminate->getOrderId());
                Assert::assertNotNull($terminate->getHeader());

                if ($terminate->getHeader() !== null) {
                    Assert::assertSame('123456', $terminate->getHeader()->getPartnerReference());
                }
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/TerminateOrderResponse.xml')
        );
    }

    /**
     * @test
     */
    public function callbackTerminateOrderDeclined(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/TerminateRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CALLBACK_ERROR, new class() implements ErrorObserverInterface {
            public function execute(Error $error): void
            {
                Assert::assertEquals(2, count($error->getMessages()));
                Assert::assertEquals('Opheffing van order 13608691 kan niet worden uitgevoerd.', $error->getMessages()[0]);
                Assert::assertEquals('Order heeft een ongeldige status. Opheffing van order 13608691 kan niet worden uitgevoerd.', $error->getMessages()[1]);
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/TerminateOrderDeclined.xml')
        );
    }
}
