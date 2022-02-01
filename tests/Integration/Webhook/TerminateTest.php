<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Terminate;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
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
    public function callbackTerminateCreate(): void
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
}
