<?php declare(strict_types = 1);

namespace Integration\Component;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\TenantDomainOwnershipResponse;

final class TenantDomainOwnershipTest extends TestCase
{
    /**
     * @test
     */
    public function hasDomainOwnershipSuccess(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/MicrosoftTenantDomainOwnershipCheckResponse_V1.xml'))]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $domainOwnershipResponse = $officeClient->customer->hasTenantDomainOwnership(123, '321');

        Assert::assertInstanceOf(TenantDomainOwnershipResponse::class, $domainOwnershipResponse);
        Assert::assertSame('Success', $domainOwnershipResponse->getStatus()->getCode());
    }

    /**
     * @test
     */
    public function hasDomainOwnershipError(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Response/NinaResponse_Fail.xml'))]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $this->expectException(Office365Exception::class);

        $officeClient->customer->hasTenantDomainOwnership(123, '321');
    }
}
