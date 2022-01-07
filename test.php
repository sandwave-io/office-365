<?php declare(strict_types=1);

use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Enum\Event as KpnEvent;
use SandwaveIo\Office365\Office\OfficeClient;

require "vendor/autoload.php";


$xml = '

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
    </NewCustomerRequest_V1>
';


$client = new OfficeClient(
    'https://kpn',
    'username',
    'password',
);

class MyfooBar implements \SandwaveIo\Office365\Observer\CustomerObserverInterface
{
    public function execute(Customer $customer): void
    {
        echo $customer->getName();
    }
}

$client->webhook->addEventSubscriber(KpnEvent::CUSTOMER_CREATE, new MyfooBar());

$customer = $client->customer->create('name');
$response = $client->webhook->parse($xml);

echo $customer->getHeader()->getPartnerReference();
