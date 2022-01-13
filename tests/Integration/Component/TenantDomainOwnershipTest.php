<?php declare(strict_types = 1);

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
        $response = '<MicrosoftTenantDomainOwnershipCheckResponse_V1><Status><Messages><string>Hello world!</string></Messages><Code>Success</Code></Status><IsDelegatedAccessAllowed>true</IsDelegatedAccessAllowed><IsAcceptanceMcaRequired>false</IsAcceptanceMcaRequired><IsOnboardingReady>true</IsOnboardingReady><DnsBoardingRecordName>dns-name</DnsBoardingRecordName><DnsBoardingRecordValue>dns-value</DnsBoardingRecordValue></MicrosoftTenantDomainOwnershipCheckResponse_V1>';

        $mockHandler = new MockHandler(
            [new Response(200, [], $response)]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $domainOwnershipResponse = $officeClient->tenant->hasTenantDomainOwnership(123, '321');

        Assert::assertInstanceOf(TenantDomainOwnershipResponse::class, $domainOwnershipResponse);
        Assert::assertSame('Success', $domainOwnershipResponse->getStatus()->code);
    }

    /**
     * @test
     */
    public function hasDomainOwnershipError(): void
    {
        $ninaResponse = '<NinaResponse><IsSuccess>false</IsSuccess><ErrorCode>108</ErrorCode><ErrorMessage>Is stuk</ErrorMessage></NinaResponse>';

        $mockHandler = new MockHandler(
            [new Response(200, [], $ninaResponse)]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $this->expectException(Office365Exception::class);

        $officeClient->tenant->hasTenantDomainOwnership(123, '321');
    }
}
