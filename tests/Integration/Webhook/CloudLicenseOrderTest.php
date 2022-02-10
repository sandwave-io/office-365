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

        if ($license->getHeader() !== null) {
            Assert::assertSame('12345', $license->getHeader()->getPartnerReference());
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
            public function execute(CloudLicense $license): void
            {
                Assert::assertSame('JohnDoe', $license->getCloudTenant()->getName());
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml')
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
}
