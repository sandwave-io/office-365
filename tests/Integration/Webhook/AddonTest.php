<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Addon;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Helper\EntityHelper;

final class AddonTest extends TestCase
{
    /**
     * @test
     */
    public function incomingCustomer(): void
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
}
