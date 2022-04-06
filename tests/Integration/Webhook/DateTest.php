<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Entity\Error;
use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SandwaveIo\Office365\Entity\Terminate;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerObserverInterface;
use SandwaveIo\Office365\Library\Observer\Error\ErrorObserverInterface;
use SandwaveIo\Office365\Library\Observer\Order\OrderModifyQuantityObserverInterface;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SandwaveIo\Office365\Library\Observer\Terminate\TerminateObserverInterface;
use SandwaveIo\Office365\Office\OfficeClient;

final class DateTest extends TestCase
{
    /**
     * @test
     */
    public function deserializeArrayPrefHeaderDate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/NewCustomerRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CUSTOMER_CREATE, new class() implements CustomerObserverInterface {
            public function execute(Customer $customer, ?Status $status): void
            {
                if ($customer->getHeader() !== null) {
                    Assert::assertSame('2022-02-15 15:14:09', $customer->getHeader()->getDateCreated()->format('Y-m-d H:i:s'));
                }
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/NewCustomerResponse_V3.xml')
        );
    }

    /**
     * @test
     */
    public function deserializeXmlPrefHeaderDate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/NewCustomerRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::ORDER_MODIFY_QUANTITY, new class() implements OrderModifyQuantityObserverInterface {
            public function execute(OrderModifyQuantity $order, ?Status $status): void
            {
                if ($order->getHeader() !== null) {
                    Assert::assertSame('2022-03-07 12:09:56', $order->getHeader()->getDateCreated()->format('Y-m-d H:i:s'));
                }
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/ModifyOrderQuantityResponse.xml')
        );
    }
}
