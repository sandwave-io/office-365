<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\AgreementContact;
use SandwaveIo\Office365\Entity\CloudAgreementContact;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Contact\ContactObserverInterface;
use SandwaveIo\Office365\Office\OfficeClient;

final class CloudAgreementTest extends TestCase
{
    /**
     * @test
     */
    public function incomingCloudAgreement(): void
    {
        /** @var CloudAgreementContact $cloudAgreement */
        $cloudAgreement = EntityHelper::createFromXML(
            (string) file_get_contents(__DIR__ . '/../Data/Request/CloudAgreementRequest.xml')
        );

        Assert::assertInstanceOf(CloudAgreementContact::class, $cloudAgreement);
        Assert::assertSame($cloudAgreement->getCustomerId(), 1);
        Assert::assertInstanceOf(PartnerReferenceHeader::class, $cloudAgreement->getHeader());
        Assert::assertInstanceOf(AgreementContact::class, $cloudAgreement->getContact());
    }

    /**
     * @test
     */
    public function callbackContactCreate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/CloudAgreementRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CLOUD_AGREEMENT_CREATE, new class() implements ContactObserverInterface {
            public function execute(CloudAgreementContact $agreementContact): void
            {
                Assert::assertEquals('john', $agreementContact->getContact()->getFirstName());
                Assert::assertEquals('doe', $agreementContact->getContact()->getLastName());
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Request/CloudAgreementRequest.xml')
        );
    }
}
