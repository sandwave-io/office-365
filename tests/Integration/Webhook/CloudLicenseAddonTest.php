<?php declare(strict_types = 1);

namespace Integration\Webhook;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Addon;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Addon\AddonObserverInterface;
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
        Assert::assertSame($addon->getParentOrderId(), 12345);
        Assert::assertSame($addon->getProductCode(), 'sandwave1');
        Assert::assertSame($addon->getQuantity(), 38);
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
            public function execute(Addon $addon): void
            {
                Assert::assertEquals('sandwave1', $addon->getProductCode());
            }
        });

        $client->webhook->process(
            (string) file_get_contents(__DIR__ . '/../Data/Request/AddonRequest.xml')
        );
    }
}
