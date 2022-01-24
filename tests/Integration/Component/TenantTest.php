<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Component;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\CloudTenant;
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

        $tenantExistsResponse = $officeClient->tenant->exists('test');

        Assert::assertInstanceOf(TenantExistsResponse::class, $tenantExistsResponse);
        Assert::assertSame('Success', $tenantExistsResponse->getStatus()->getCode());
    }

    /**
     * @test
     */
    public function get(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/CloudTenantResponse_V1.xml'))]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $cloudTenantResponse = $officeClient->tenant->get('test');

        Assert::assertInstanceOf(CloudTenantResponse::class, $cloudTenantResponse);
        Assert::assertSame('Success', $cloudTenantResponse->getStatus()->getCode());
    }
}
