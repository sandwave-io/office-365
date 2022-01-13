<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Tests\Integration\Webhook;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Enum\RequestAction;
use SandwaveIo\Office365\Helper\EntityHelper;

final class CustomerTest extends TestCase
{
    /**
     * @test
     */
    public function incomingCustomer(): void
    {
        $incomingCustomerXml = '
            <NewCustomerRequest_V1>
                <Header>
                    <PartnerReference>21139</PartnerReference>
                    <DateCreated>2014-06-20T14:37:00</DateCreated>
                </Header>
                <Name>Naam Klant</Name>
                <Street>StraatNaam</Street>
                <HouseNr>38</HouseNr>
                <HouseNrExtension />
                <ZipCode>1234AB</ZipCode>
                <City>Amsterdam</City>
                <CountryCode>NLD</CountryCode>
                <Phone1>0612345678</Phone1>
                <Email>klant@email.nl</Email>
                <Website />
                <DebitNr />
                <LegalStatus>CV</LegalStatus>
            </NewCustomerRequest_V1>';

        /** @var Customer $customer */
        $customer = EntityHelper::createFromXML($incomingCustomerXml, RequestAction::NEW_CUSTOMER_REQUEST_V1);
        Assert::assertInstanceOf(Customer::class, $customer);
        Assert::assertSame($customer->getName(), 'Naam Klant');
    }
}
