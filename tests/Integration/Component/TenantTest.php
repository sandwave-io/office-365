<?php declare(strict_types = 1);

namespace Integration\Component;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\CloudTenantResponse;
use SandwaveIo\Office365\Response\TenantExistsResponse;

final class TenantTest extends TestCase
{
    /**
     * @test
     */
    public function exists(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/MicrosoftTenantExistsCheckResponse_V1.xml'))]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $tenantExistsResponse = $officeClient->tenant->exists('test.onmicrosoft.com');

        Assert::assertInstanceOf(TenantExistsResponse::class, $tenantExistsResponse);
        Assert::assertSame('Success', $tenantExistsResponse->getStatus()->getCode());
    }

    /**
     * @test
     */
    public function fetchTenant(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/CloudTenantResponse_V1.xml'))]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $cloudTenantResponse = $officeClient->tenant->fetchTenant(1234);

        Assert::assertInstanceOf(CloudTenantResponse::class, $cloudTenantResponse);
        Assert::assertSame('Success', $cloudTenantResponse->getStatus()->getCode());
    }
}
