<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\CloudLicense;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\CloudLicense\CloudLicenseObserverInterface;
use SandwaveIo\Office365\Office\OfficeClient;

final class CloudLicenseOrderTest extends TestCase
{
    /**
     * @test
     */
    public function createCloudLicenseTest(): void
    {
        /** @var CloudLicense $license */
        $license = EntityHelper::createFromXML( (string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml'));
        Assert::assertInstanceOf(CloudLicense::class, $license);
        Assert::assertSame($license->getCloudTenant()->getName(), 'JohnDoe');
        Assert::assertSame($license->getCloudTenant()->getAgreementContact()->getFirstName(), 'Jane');

        if ($license->getHeader() !== null) {
            Assert::assertSame($license->getHeader()->getPartnerReference(), '12345');
        }
    }

    public function testCallbackLicenseCreate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CLOUD_LICENSE_ORDER_CREATE, new class implements CloudLicenseObserverInterface
        {
            public function execute(CloudLicense $license): void
            {
                Assert::assertEquals('JohnDoe', $license->getCloudTenant()->getName());
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml')
        );
    }
}
