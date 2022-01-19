<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\CloudLicense;
use SandwaveIo\Office365\Helper\EntityHelper;

final class CloudLicenseOrderTest extends TestCase
{
    /**
     * @test
     */
    public function createCloudLicenseTest(): void
    {
        /** @var CloudLicense $license */
        $license = EntityHelper::createFromXML((string) file_get_contents(__DIR__ . '/../Data/Request/NewCloudLicenseOrderRequest.xml'));
        Assert::assertInstanceOf(CloudLicense::class, $license);
        Assert::assertSame($license->getCloudTenant()->getName(), 'JohnDoe');
        Assert::assertSame($license->getCloudTenant()->getAgreementContact()->getFirstName(), 'Jane');
        Assert::assertSame($license->getHeader()->getPartnerReference(), '12345');
    }
}
