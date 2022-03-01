<?php declare(strict_types = 1);

namespace Integration\Component;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\QueuedResponse;

final class CloudLicenseOrderTest extends TestCase
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

        $tenant = $officeClient->tenant->create(
            'test.onmicrosoft.com',
            'Sandwave',
            'Test',
            'john@doe.com',
            [
                'firstname' => 'john',
                'lastname' => 'doe',
                'email' => 'john@doe.com',
                'phoneNumber' => '12345',
                'agreed' => (new \DateTime())->format('Y-m-d'),
            ]
        );

        $customerResponse = $officeClient->order->cloudLicense->create(
            '507201',
            '120A00064B',
            1,
            '',
            $tenant
        );

        Assert::assertInstanceOf(QueuedResponse::class, $customerResponse);
        Assert::assertTrue($customerResponse->isSuccess());
        Assert::assertSame(0, $customerResponse->getErrorCode());
    }
}
