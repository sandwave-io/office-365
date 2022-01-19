<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Component;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\QueuedResponse;

final class CustomerTest extends TestCase
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

        $customerResponse = $officeClient->customer->create(
            'Naam Klant',
            'StraatNaam',
            38,
            null,
            '1234AB',
            'Amsterdam',
            'NLD',
            '0612345678',
            null,
            null,
            'klant@email.nl',
            null,
            null,
            null,
            null,
            'CV',
            null,
            null,
        );

        Assert::assertInstanceOf(QueuedResponse::class, $customerResponse);
        Assert::assertTrue($customerResponse->isSuccess());
        Assert::assertSame('Success', $customerResponse->getErrorMessage());
        Assert::assertSame(0, $customerResponse->getErrorCode());
    }
}
