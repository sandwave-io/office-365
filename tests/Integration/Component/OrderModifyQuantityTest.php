<?php declare(strict_types = 1);

namespace Integration\Component;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\QueuedResponse;

final class OrderModifyQuantityTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/NinaResponseSuccess.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $response = $officeClient->order->modify(
            10035367,
            0,
            false,'123'
        );

        Assert::assertInstanceOf(QueuedResponse::class, $response);
        Assert::assertTrue($response->isSuccess());
        Assert::assertSame(0, $response->getErrorCode());
    }
}
