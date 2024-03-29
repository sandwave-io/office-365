<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Error;
use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Error\ErrorObserverInterface;
use SandwaveIo\Office365\Library\Observer\Order\OrderModifyQuantityObserverInterface;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SandwaveIo\Office365\Office\OfficeClient;

final class OrderModifyQuantityTest extends TestCase
{
    /**
     * @test
     */
    public function createOrdermodify(): void
    {
        /** @var OrderModifyQuantity $modification */
        $modification = EntityHelper::createFromXML((string) file_get_contents(__DIR__ . '/../Data/Request/OrderModifyQuantityRequest.xml'));
        Assert::assertInstanceOf(OrderModifyQuantity::class, $modification);
        Assert::assertSame(4, $modification->getQuantity());

        if ($modification->getHeader() !== null) {
            Assert::assertSame($modification->getHeader()->getPartnerReference(), '12345');
        }
    }

    /**
     * @test
     */
    public function callbackOrderModify(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/OrderModifyQuantityRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::ORDER_MODIFY_QUANTITY, new class() implements OrderModifyQuantityObserverInterface {
            public function execute(OrderModifyQuantity $modifyQuantity, ?Status $status): void
            {
                Assert::assertSame(10264559, $modifyQuantity->getUpgradeOrderId());
                Assert::assertSame(10264351, $modifyQuantity->getOrderId());
                Assert::assertNull($modifyQuantity->isDelta());
                Assert::assertNull($modifyQuantity->getQuantity());

                if ($modifyQuantity->getHeader() !== null) {
                    Assert::assertSame('OFFICE365-ID-14775-29241', $modifyQuantity->getHeader()->getPartnerReference());
                    Assert::assertSame('2022-03-07T12:09:56', $modifyQuantity->getHeader()->getDateCreated()->format('Y-m-d\TH:i:s'));
                }
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/ModifyOrderQuantityResponse.xml')
        );
    }

    /**
     * @test
     */
    public function callbackModifyOrderDeclined(): void
    {
        $this->expectNotToPerformAssertions();

        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/OrderModifyQuantityRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CALLBACK_ERROR, new class() implements ErrorObserverInterface {
            public function execute(Error $error): void
            {
                Assert::assertEquals(1, count($error->getMessages()));
                Assert::assertEquals('Order is bezet. Detailgegevens van order 13608691 kunnen niet worden bewerkt.', $error->getMessages()[0]);
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/ModifyOrderDeclined.xml')
        );
    }
}
