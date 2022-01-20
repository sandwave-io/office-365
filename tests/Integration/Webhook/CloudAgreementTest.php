<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\CloudAgreementContact;
use SandwaveIo\Office365\Entity\CloudAgreementContact\AgreementContact;
use SandwaveIo\Office365\Entity\Header\PartnerReferenceHeader;
use SandwaveIo\Office365\Helper\EntityHelper;

final class CloudAgreementTest extends TestCase
{
    /**
     * @test
     */
    public function incomingCustomer(): void
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
}
