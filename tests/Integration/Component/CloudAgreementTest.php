<?php declare(strict_types = 1);

namespace Integration\Component;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\QueuedResponse;
use SandwaveIo\Office365\Entity\CloudAgreementContact\AgreementContact;

final class CloudAgreementTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $response = '<NewCloudAgreementContactResponse_V1>
            <Header><PartnerReference>1</PartnerReference><DateCreated>2022-01-13 15:00:00</DateCreated></Header>
            <SuccessStatus_V1><Code>Active</Code><Messages>test</Messages></SuccessStatus_V1>
        </NewCloudAgreementContactResponse_V1>';

        $mockHandler = new MockHandler(
            [new Response(200, [], $response)]
        );
        $stack = HandlerStack::create($mockHandler);
        $officeClient = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $cloudAgreementResponse = $officeClient->cloudAgreementContact->create(
            null,
            1,
            new AgreementContact()
        );

        dd($cloudAgreementResponse);

//        Assert::assertInstanceOf(QueuedResponse::class, $customerResponse);
//        Assert::assertTrue($customerResponse->isSuccess());
//        Assert::assertSame('Success', $customerResponse->getErrorMessage());
//        Assert::assertSame(0, $customerResponse->getErrorCode());
    }
}
