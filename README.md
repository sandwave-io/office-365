# Office 365

This is a package for the microsoft 365 package for KPN

## SERVER COMMUNICATION

### RouteIT

This package will not communicate directly with KPN but with an intermediate party called RouteIT.
RouteIT handles every other request detail.

### Authentication

Each request must contain a header for basic authentication

## PACKAGE

### OfficeClient

The office client is the API for this package. Example setup

```php
<?php declare(strict_types = 1);

use SandwaveIo\Office365\Office\OfficeClient;

$client = new OfficeClient(
    'https://my.awesome.domain',
    'username',
    'password',
);

```

### Testing with the OfficeClient

The OfficeClient accepts an array as fourth parameter. This array will be merged together
with the default GuzzleClient parameters. This gives the benefit of setting a handler for mocking for example.

Default GuzzleHttp options:

```php
[
    'auth' => ['username', 'password'],
    'base_uri' => 'https://somehost',
    'headers' => [
        'Content-Type' => 'text/xml; charset=UTF8'
    ],
]
```

Instantiate the OfficeClient with a MockHandler

```php
$mock = new MockHandler([
    new Response(200, ['X-Foo' => 'Bar'], 'Hello, World'),
    new Response(202, ['Content-Length' => 0]),
    new RequestException('Error Communicating with Server', new Request('GET', 'test'))
]);

$handlerStack = HandlerStack::create($mock);

$officeClient = new OfficeClient('username', 'password', ['handler' => $handlerStack]);
```


### Available components and their methods

#### Customer

##### Create

Accepts
- (string)</span> $name (the customer name)

```php
$client = new OfficeClient('https://my.awesome.domain', 'username', 'password');
$customer = $client->customer->create('name');
```

## Asynchronous requests

### Subscribed events

Not every request will be synchronous and will give back a resource immediately. RouteIT will call our webhook with the particular 
object that has been created. This will cause that the Office365 package dispatches an event. Each subscriber that is attached to 
that particular event will receive the notification.

### Subscribe to an event

For example: a customer create request is sent. RouteIT will not give back the resource immediately but will send this later
through the webhook. In order to subscribe for this particular event, a new class must be created that implements the `CustomerObserverInterface`.
Each component holds his own observers. The interface name will always look like this `{ComponentName}ObserverInterface`.

```php
class CustomerCreateListener implements CustomerObserverInterface
{
    public function execute(Customer $customer): void
    {
        echo $customer->getName();
    }
}
```

In the above class, the CustomerObserverInterface is created and the `execute` method is implemented.
It can now be attached together with an event it should listen to. In this case `OfficeEvent::CUSTOMER_CREATE`.

```php
$client->webhook->addEventSubscriber(OfficeEvent::CUSTOMER_CREATE, new CustomerCreateListener());
$response = $client->webhook->parse($xml);
```
