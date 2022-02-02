<?php declare(strict_types = 1);

namespace Integration\Component;

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
    public function customerCreate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/NinaResponse_Success.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $officeClient = new OfficeClient('https://api.routit.nl', 'yourhosting_bv', 'm_wyd44MRbfEJLgqDiEgA');

        $customerResponse = $officeClient->customer->create(
            'Sandwave test',
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
            null,
            'CV',
            null,
            null,
            '134534659043869034809635435',
        );

        var_dump($customerResponse);

        Assert::assertInstanceOf(QueuedResponse::class, $customerResponse);
        Assert::assertTrue($customerResponse->isSuccess());
        Assert::assertSame(0, $customerResponse->getErrorCode());
    }

    /**
     * @test
     */
    public function customerModify(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/NinaResponse_Success.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $customerResponse = $officeClient->customer->modify(
            'CID1322912',
            'Naam',
            'StraatNaam',
            38,
            '',
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
            null,
            'CV',
            null,
            null,
            '134534659043869034809635435',
        );

        Assert::assertInstanceOf(QueuedResponse::class, $customerResponse);
        Assert::assertTrue($customerResponse->isSuccess());
        Assert::assertSame(0, $customerResponse->getErrorCode());
    }

    public function customerUpdate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/NinaResponse_Success.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $customerResponse = $officeClient->customer->modify(
            'CID1322912',
            'Naam',
            'StraatNaam',
            38,
            '',
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
            null,
            'CV',
            null,
            null,
            '134534659043869034809635435',
        );

        Assert::assertInstanceOf(QueuedResponse::class, $customerResponse);
        Assert::assertTrue($customerResponse->isSuccess());
        Assert::assertSame(0, $customerResponse->getErrorCode());
    }
}
