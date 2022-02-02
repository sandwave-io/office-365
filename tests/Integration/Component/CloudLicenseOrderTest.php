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
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/NinaResponseSuccess.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $tenant = $officeClient->tenant->create('test.onmicrosoft.com', 'Sandwave', 'Test', 'john@doe.com');
        $contact = $officeClient->contact->agreement->create('sandwave test', 'john', 'doe', 'john@doe.com', '12345', new \DateTime());

        $customerResponse = $officeClient->order->cloudLicense->create(
            $tenant,
            $contact,
            '507201',
            '120A00064B',
            1
        );

        Assert::assertInstanceOf(QueuedResponse::class, $customerResponse);
        Assert::assertTrue($customerResponse->isSuccess());
        Assert::assertSame(0, $customerResponse->getErrorCode());
    }
}
