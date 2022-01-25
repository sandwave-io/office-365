<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Order\OrderModifyQuantityObserverInterface;
use SandwaveIo\Office365\Office\OfficeClient;

final class OrderModifyQuantityTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateOrdermodify(): void
    {
        /** @var OrderModifyQuantity $modification */
        $modification = EntityHelper::createFromXML((string) file_get_contents(__DIR__ . '/../Data/Request/OrderModifyQuantityRequest.xml'));
        Assert::assertInstanceOf(OrderModifyQuantity::class, $modification);
        Assert::assertSame($modification->getQuantity(), 4);

        if ($modification->getHeader() !== null) {
            Assert::assertSame($modification->getHeader()->getPartnerReference(), '12345');
        }
    }

    public function testCallbackOrderModify(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/OrderModifyQuantityRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::ORDER_MODIFY_QUANTITY, new class() implements OrderModifyQuantityObserverInterface {
            public function execute(OrderModifyQuantity $modifyQuantity): void
            {
                Assert::assertEquals(4, $modifyQuantity->getQuantity());
                Assert::assertEquals(123, $modifyQuantity->getOrderId());
                Assert::assertTrue($modifyQuantity->isDelta());

                if ($modifyQuantity->getHeader() !== null) {
                    Assert::assertEquals('12345', $modifyQuantity->getHeader()->getPartnerReference());
                }
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Request/OrderModifyQuantityRequest.xml')
        );
    }
}
