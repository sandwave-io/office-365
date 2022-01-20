<?php declare(strict_types = 1);

namespace Integration\Component;

use DateTime;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\CloudAgreementContact\AgreementContact;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;
use SandwaveIo\Office365\Office\OfficeClient;
use SandwaveIo\Office365\Response\QueuedResponse;

final class CloudAgreementTest extends TestCase
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

        $cloudAgreementResponse = $officeClient->cloudAgreementContact->create(
            new PartnerReferenceHeader('ABC123', new DateTime('NOW')),
            1,
            new AgreementContact('john', 'doe', 'test@sandwave.io', '123456', new DateTime('NOW'))
        );

        Assert::assertInstanceOf(QueuedResponse::class, $cloudAgreementResponse);
        Assert::assertTrue($cloudAgreementResponse->isSuccess());
        Assert::assertSame('Success', $cloudAgreementResponse->getErrorMessage());
        Assert::assertSame(0, $cloudAgreementResponse->getErrorCode());
    }
}
