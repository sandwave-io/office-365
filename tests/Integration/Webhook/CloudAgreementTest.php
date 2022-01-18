<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\CloudAgreementContact;
use SandwaveIo\Office365\Entity\CloudAgreementContact\AgreementContact;
use SandwaveIo\Office365\Entity\Header\CustomerHeader;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Helper\EntityHelper;

final class CloudAgreementTest extends TestCase
{
    /**
     * @test
     */
    public function incomingCustomer(): void
    {
        $incomingCloudAgreementXml = (string) file_get_contents(__DIR__ . '/../Data/Webhook/CloudAgreement.xml');

        /** @var CloudAgreementContact $cloudAgreement */
        $cloudAgreement = EntityHelper::createFromXML($incomingCloudAgreementXml, RequestAction::NEW_CLOUD_AGREEMENT_CONTACT_REQUEST_V1);
        Assert::assertInstanceOf(CloudAgreementContact::class, $cloudAgreement);
        Assert::assertSame($cloudAgreement->getCustomerId(), 1);
        Assert::assertInstanceOf(CustomerHeader::class, $cloudAgreement->getHeader());
        Assert::assertInstanceOf(AgreementContact::class, $cloudAgreement->getContact());
    }
}
