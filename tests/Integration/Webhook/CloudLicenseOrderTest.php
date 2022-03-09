<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\CloudLicense;
use SandwaveIo\Office365\Entity\Error;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\CloudLicense\CloudLicenseObserverInterface;
use SandwaveIo\Office365\Library\Observer\Error\ErrorObserverInterface;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SandwaveIo\Office365\Office\OfficeClient;

final class CloudLicenseOrderTest extends TestCase
{
    /**
     * @test
     */
    public function cloudLicenseOrderTest(): void
    {
        /** @var CloudLicense $license */
        $license = EntityHelper::createFromXML((string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml'));

        Assert::assertInstanceOf(CloudLicense::class, $license);
        Assert::assertSame('JohnDoe', $license->getCloudTenant()->getName());
        Assert::assertSame('Jane', $license->getCloudTenant()->getAgreementContact()->getFirstName());

        if ($license->getPartnerReferenceHeader() !== null) {
            Assert::assertSame('12345', $license->getPartnerReferenceHeader()->getPartnerReference());
        }
    }

    /**
     * @test
     */
    public function callbackLicenseOrderCreate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CLOUD_LICENSE_ORDER_CREATE, new class() implements CloudLicenseObserverInterface {
            public function execute(CloudLicense $license, ?Status $status): void
            {
                Assert::assertSame('Sandwave', $license->getCloudTenant()->getFirstName());
                Assert::assertSame('Test', $license->getCloudTenant()->getLastName());
                Assert::assertSame('john@doe.com', $license->getCloudTenant()->getEmail());
                Assert::assertSame('testwillem1.onmicrosoft.com', $license->getCloudTenant()->getName());
                Assert::assertSame('john@doe.com', $license->getCloudTenant()->getAgreementContact()->getEmail());
                Assert::assertSame('john', $license->getCloudTenant()->getAgreementContact()->getFirstName());
                Assert::assertSame('doe', $license->getCloudTenant()->getAgreementContact()->getLastName());
                Assert::assertSame('2022-03-01', $license->getCloudTenant()->getAgreementContact()->getAgreed());
                Assert::assertSame('12345', $license->getCloudTenant()->getAgreementContact()->getPhoneNumber());

                if ($status !== null) {
                    Assert::assertSame('active', $status->getStatusCode());
                }
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/CloudLicenseActiveResponse.xml')
        );
    }

    /**
     * @test
     */
    public function callbackOrderDeclined(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CALLBACK_ERROR, new class() implements ErrorObserverInterface {
            public function execute(Error $error): void
            {
                Assert::assertSame(1, count($error->getMessages()));
                Assert::assertSame('ProductCode: Product SANDWAVE111 kan niet besteld worden als addon bij product 120A00044B', $error->getMessages()[0]);
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/OrderDeclined.xml')
        );
    }

    /**
     * @test
     */
    public function callbackOrderActive(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CLOUD_LICENSE_ORDER_CREATE, new class() implements CloudLicenseObserverInterface {
            public function execute(CloudLicense $cloudLicense, ?Status $status): void
            {
                Assert::assertSame(10233813, $cloudLicense->getOrderId());
                Assert::assertSame('120A00001B', $cloudLicense->getProductCode());
                Assert::assertSame(2, $cloudLicense->getQuantity());
                Assert::assertSame('507201', $cloudLicense->getCustomerId());
                Assert::assertSame('Sandwave', $cloudLicense->getCloudTenant()->getFirstName());
                Assert::assertSame('Test', $cloudLicense->getCloudTenant()->getLastName());
                Assert::assertSame('19971729-e2bb-4000-ad3c-7a22f3db023b', $cloudLicense->getCloudTenant()->getTenantId());
                Assert::assertSame('john@doe.com', $cloudLicense->getCloudTenant()->getEmail());
                Assert::assertSame('john@doe.com', $cloudLicense->getCloudTenant()->getAgreementContact()->getEmail());
                Assert::assertSame('john', $cloudLicense->getCloudTenant()->getAgreementContact()->getFirstName());
                Assert::assertSame('doe', $cloudLicense->getCloudTenant()->getAgreementContact()->getLastName());
                Assert::assertSame('12345', $cloudLicense->getCloudTenant()->getAgreementContact()->getPhoneNumber());
                Assert::assertSame('2022-03-01', $cloudLicense->getCloudTenant()->getAgreementContact()->getAgreed());

                if ($status !== null) {
                    Assert::assertSame('active', $status->getStatusCode());
                }
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/CloudLicenseActiveResponse.xml')
        );
    }
}
