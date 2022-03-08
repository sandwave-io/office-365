<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Addon;
use SandwaveIo\Office365\Entity\Error;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Addon\AddonObserverInterface;
use SandwaveIo\Office365\Library\Observer\Error\ErrorObserverInterface;
use SandwaveIo\Office365\Library\Observer\Status\Status;
use SandwaveIo\Office365\Office\OfficeClient;

final class CloudLicenseAddonTest extends TestCase
{
    /**
     * @test
     */
    public function incomingAddon(): void
    {
        /** @var Addon $addon */
        $addon = EntityHelper::createFromXML(
            (string) file_get_contents(__DIR__ . '/../Data/Request/AddonRequest.xml')
        );

        Assert::assertInstanceOf(Addon::class, $addon);
        Assert::assertSame(12345, $addon->getParentOrderId());
        Assert::assertSame('sandwave1', $addon->getProductCode());
        Assert::assertSame(38, $addon->getQuantity());
    }

    /**
     * @test
     */
    public function callbackLicenseAddonCreate(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/AddonRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CLOUD_LICENSE_ADDON_CREATE, new class() implements AddonObserverInterface {
            public function execute(Addon $addon, Status $status): void
            {
                Assert::assertSame('active', $status->getStatusCode());
                Assert::assertSame('actived product', $status->getMessages()[0]);
                Assert::assertSame('sandwave1', $addon->getProductCode());
                Assert::assertSame(1, $addon->getQuantity());
                Assert::assertSame(123, $addon->getParentOrderId());
                Assert::assertSame('ABCDEFGH', $addon->getLicenseKey());
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/AddonResponseSuccess.xml')
        );
    }

    /**
     * @test
     */
    public function callbackOrderDeclined(): void
    {
        $mockHandler = new MockHandler(
            [new Response(200, [], (string) file_get_contents(__DIR__ . '/../Data/Request/AddonRequest.xml'))]
        );

        $stack = HandlerStack::create($mockHandler);
        $client = new OfficeClient('example.com', 'test', 'test', ['handler' => $stack]);

        $client->webhook->addEventSubscriber(Event::CALLBACK_ERROR, new class() implements ErrorObserverInterface {
            public function execute(Error $error): void
            {
                Assert::assertEquals(1, count($error->getMessages()));
                Assert::assertEquals('ProductCode: Product SANDWAVE111 kan niet besteld worden als addon bij product 120A00044B', $error->getMessages()[0]);
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Response/OrderDeclined.xml')
        );
    }
}
