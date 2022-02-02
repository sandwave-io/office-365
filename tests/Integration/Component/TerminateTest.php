<?php declare(strict_types = 1);

namespace Integration\Component;

use DateTime;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\QueuedResponse;

final class TerminateTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/NinaResponse_Success.xml'))]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $terminateResponse = $officeClient->order->terminate(
            '10035367',
            new DateTime('NOW'),
            true,
            '123'
        );

        Assert::assertInstanceOf(QueuedResponse::class, $terminateResponse);
        Assert::assertTrue($terminateResponse->isSuccess());
        Assert::assertSame('Success', $terminateResponse->getErrorMessage());
        Assert::assertSame(0, $terminateResponse->getErrorCode());
    }
}
