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
            'attribute',
            null,
            50,
        );

        Assert::assertInstanceOf(OrderSummaryResponse::class, $response);
        Assert::assertSame('Success', $response->getStatus()->getCode());
    }
}
