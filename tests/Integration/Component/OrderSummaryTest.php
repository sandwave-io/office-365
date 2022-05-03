<?php declare(strict_types = 1);

namespace Integration\Component;

use DateTime;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\OrderSummaryResponse;

final class OrderSummaryTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/OrderSummaryResponse_V1.xml'))]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $response = $officeClient->order->summary(
            1234,
            'Activate',
            'Security',
            'Productname',
            new DateTime(),
            new DateTime(),
            new DateTime(),
            null,
            'label',
            null,
            null,
            50,
        );

        Assert::assertInstanceOf(OrderSummaryResponse::class, $response);
        Assert::assertCount(2, $response->getPagedResult()->getResults());
        Assert::assertSame('Success', $response->getStatus()->getCode());
        Assert::assertSame(25, $response->getPagedResult()->getTotal());
        Assert::assertSame(2, count($response->getPagedResult()->getResults()));
        Assert::assertSame('Activate', $response->getPagedResult()->getResults()[0]->getOrderState());
        Assert::assertSame(10, $response->getPagedResult()->getResults()[0]->getQuantity());
    }
}
