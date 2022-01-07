<?php declare(strict_types=1);

use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Enum\Event as OfficeEvent;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerObserverInterface;
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

/**
 * CustomerCreateListener implements the CustomerObserverInterface
 * The Office365 package must provide a unique {Component}ObserverInterface for each component
 * so the client (Argeweb, Waterfront) can implement it into a class which they have full control over
 */
class CustomerCreateListener implements CustomerObserverInterface
{
    public function execute(Customer $customer): void
    {
        echo $customer->getName();
    }
}

/**
 * instantiate the office client with a host, username and password
 */
$client = new OfficeClient(
    'https://www.google.nl',
    'username',
    'password',
);

/**
 * create a class specifically for a customer observer
 * pass the object with the correct interface implementation to the client event subscriber
 */
$client->webhook->addEventSubscriber(OfficeEvent::CUSTOMER_CREATE, new CustomerCreateListener());
$response = $client->webhook->parse($xml);

/**
 * Create a new customer through the client
 * This will result in a async request on the RouteIT server and will use a webhook as a callback service.
 * The callback/event will contain the full created Customer (see the CustomerCreateListener)
 * The object returned from this create method is a Customer object but most likely incomplete
 */
$customer = $client->customer->create('name', '123456');
echo $customer->getHeader()->getPartnerReference();
