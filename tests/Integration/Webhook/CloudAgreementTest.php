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
        $incomingCloudAgreementXml = '
            <NewCloudAgreementContactRequest_V1>
                <Header>
                    <PartnerReference>21139</PartnerReference>
                    <DateCreated>2014-06-20T14:37:00</DateCreated>
                </Header>
                <CustomerId>1</CustomerId>
                <AgreementContact>
                    <FirstName>john</FirstName>
                    <LastName>doe</LastName>
                    <EmailAddress>klant@email.nl</EmailAddress>
                    <PhoneNumber>0612345678</PhoneNumber>
                    <DateCreated>2014-06-20T14:37:00</DateCreated>
                </AgreementContact>
            </NewCloudAgreementContactRequest_V1>';

        /** @var CloudAgreementContact $cloudAgreement */
        $cloudAgreement = EntityHelper::createFromXML($incomingCloudAgreementXml, RequestAction::NEW_CLOUD_AGREEMENT_CONTACT_REQUEST_V1);
        var_dump($cloudAgreement);
        Assert::assertInstanceOf(CloudAgreementContact::class, $cloudAgreement);
        Assert::assertSame($cloudAgreement->getCustomerId(), 1);
        Assert::assertInstanceOf(CustomerHeader::class, $cloudAgreement->getHeader());
        Assert::assertInstanceOf(AgreementContact::class, $cloudAgreement->getContact());
    }
}
